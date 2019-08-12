<?php

namespace App\Http\Controllers;

use App\Assignment;
use App\Question;
use App\BookQuestion;
use App\Section;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class AssignmentController extends Controller
{
    public function all(Assignment $assignment){
        $sections = $assignment->sections;
        $theData = array();
        $theData['id'] = $assignment->id;
        $theData['name'] = $assignment->name;
        $theData['sections'] = array();
        foreach ($sections as $i => $section) {
            //$questions[str_replace(" ", "_", $section->subject->name)] = $section->questions;

            $questions = array();
            foreach ($section->questions as $index => $question) {
                
                array_push($questions, ['id'=>$question->id, 'question_number'=>$question->question_number, 'assignment_id'=>$question->sections()->first()->assignment_id]);
            }

            $theData['sections'][$i] = ['id'=> strval($section->subject_id), 'name'=>$section->subject->name, 'questions'=>$questions];
        }
        return response()->json($theData);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $currentAssignments = []; 
        $pastAssignments=[];
        //get only assignments that aren't practice tests
        $assignments = Assignment::where('name', 'NOT LIKE', '%Practice%')->get();
        //find only assignments that have at least one question in each of their sections
        foreach($assignments as $assignment){
                    foreach($assignment->sections as $section){
                        if(count($section->questions)){
                            if(strtotime($assignment->due_date) > time()){
                                array_push($currentAssignments, $assignment->id);
                                break;
                            }
                            else{
                                array_push($pastAssignments, $assignment->id);
                                break;
                            }
                        }
                    }
                }

        $currentAssignments = Assignment::find($currentAssignments);
        $currentAssignments = $currentAssignments->sortBy(function ($assignment, $key) {
            return $assignment['due_date'];
        });
        $pastAssignments = Assignment::find($pastAssignments);
        $pastAssignments = $pastAssignments->sortBy(function ($assignment, $key) {
            return $assignment['due_date'];
        });

        if(Auth::user()){
            $completed= Auth::user()->assignments;
        }
        return view('assignment.index', compact('currentAssignments', 'pastAssignments', 'completed'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $questions = BookQuestion::all();
        return view('admin.assignments.create', compact('questions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->assignment, 
        ['name'=>'required|string|unique:assignments',
          'due_date'=>'required|date'
        ])->validate();
        $assignment = new Assignment;
        $assignment->name = $request->assignment['name'];
        $assignment->due_date = date("Y-m-d H:i:s", strtotime($request->assignment['due_date']) +60*60*23 +60*59 + 59+4*60*60);
        $assignment->save();
        $assignment->subjects()->sync($request->subjects);
        return redirect()->route('assignments.insert');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Assignment  $assignment
     * @return \Illuminate\Http\Response
     */
    public function show(Assignment $assignment)
    {
        if(Auth::user() && Auth::user()->assignments()->where('assignments.id', $assignment->id)->exists())
            return view('assignment.completed',  compact('assignment'));
        $sections = $assignment->sections;
        return view('assignment.show', compact('sections', 'assignment'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Assignment  $assignment
     * @return \Illuminate\Http\Response
     */
    public function insert()
    {
        $assignments = Assignment::all()->filter(function ($value, $key){
            return !strpos($value->name, "Practice");
        })->pluck('name', 'id');
        return view('admin.assignments.insert', compact('assignments'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Assignment  $assignment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Assignment $assignment)
    {
        $theData =  json_decode($request->obj);

        foreach ($theData->sections as $key => $currentSection) {
            $subject_id = $currentSection->id;
            $questionIDs = array_map(function($el){
                return $el->id;
            }, $currentSection->questions);
            $section = Section::where('assignment_id', $assignment->id)->where('subject_id', $subject_id)->first();
            $section->questions()->sync($questionIDs);
        }
        
        return redirect()->route('assignments.show', ['assignment'=>$assignment]);
    }
    public function confirm(Request $request){
        $assignment = Assignment::find($request->assignment);
        $correctString = "";
        $sections = $assignment->sections;
        $studentAnswers = $request->answers;
        foreach ($sections as $key=>$section) {
            $questions = $section->questions;
            foreach($questions as $qKey =>$question){
                if($question->correctAnswer->id ==$studentAnswers[$key][$qKey+1]){
                    $correctString .= "You got Number " . ($qKey+1) . " right in section: " . $section->subject->name . "\r\n";
                }
                //array_push($correctAnswers[$key], $question->correctAnswer->letter);
            }
        }
        $guide = [0=>'',1=>'A', 2=>'B', 3=>'C', 4=>'D'];
        return view('assignment.confirm', compact('assignment', 'studentAnswers', 'guide'));
    }
    public function process(Request $request){
        $assignment = Assignment::find($request->assignment);

        if(!Auth::user() || time() > strtotime($assignment->due_date) ){
            abort(401);
        }
        
        $assignmentUserId = DB::table('assignment_user')->insertGetId(
            ['assignment_id' => $assignment->id, 'user_id'=>Auth::user()->id, 'score'=>90]
        );
        $assignment = Assignment::find($request->assignment);
        $sections = $assignment->sections;
        $studentAnswers = $request->studentAnswers;
        foreach ($sections as $key=>$section) {
            $questions = $section->questions;
            foreach($questions as $qKey =>$question){
                DB::table('question_user')->insert(
                ['assignment_user_id' =>  $assignmentUserId, 'question_id'=>$question->id, 'user_answer'=>$studentAnswers[$key][$qKey+1]]
                );
            }
        }
        return redirect()->route('assignments.results', ['assignment'=>$assignment]);
    }

    public function results(Request $request, Assignment $assignment){
        if(is_numeric($assignment)){
            $assignment = Assignment::find($assignment);
        }
        $completedAssignment = DB::table('assignment_user')->where('assignment_id', $assignment->id)->where('user_id', Auth::user()->id)->first();
        if(!$completedAssignment){
            abort(404);
        }

        $sections = $assignment->sections;
        $studentAnswers = array();
        foreach ($sections as $key=>$section) {
            $studentAnswers[$key] = array();
            $questions = $section->questions;
            foreach($questions as $qKey =>$question){
                if(Auth::user())
                $completedQuestion = DB::table('question_user')->where('question_id', $question->id)->where('assignment_user_id',$completedAssignment->id)->first();
                if($completedQuestion){
                array_push($studentAnswers[$key], $completedQuestion->user_answer);
                }
            }
        }
        $guide = [0=>'',1=>'A', 2=>'B', 3=>'C', 4=>'D'];
        return view('assignment.results', compact('assignment', 'sections', 'studentAnswers', 'guide'));
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Assignment  $assignment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Assignment $assignment)
    {
        //
    }
}
