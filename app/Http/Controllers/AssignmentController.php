<?php

namespace App\Http\Controllers;

use App\Assignment;
use App\Question;
use App\BookQuestion;
use App\Section;
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
                
                array_push($questions, ['id'=>$question->id, 'question_number'=>$question->question_number]);
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
        $assignments = Assignment::all();
        if(Auth::user()){
            $completed= Auth::user()->assignments;
        }
        else{
            $completed = array();
        }
        return view('assignment.index', compact('assignments', 'completed'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $questions = BookQuestion::all();
        return view('assignment.create', compact('questions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function edit()
    {
        $assignments = Assignment::all()->pluck('name', 'id');
        return view('admin.assignments.edit', compact('assignments'));
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


        foreach ($theData->sections as $key => $sectionQuestions) {
            $subject_id = $sectionQuestions[0];
            $ids = array_map(function($el){
                return $el->id;
            }, $sectionQuestions[1]->questions);
            $section = Section::where('assignment_id', $assignment->id)->where('subject_id', $subject_id)->first();
            $section->questions()->sync($ids);
            //$section->questions()->sync(); //sync needs the ids of the book questions
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
        if(!Auth::user()){
            abort(401);
        }
        
        $assignmentId = DB::table('assignment_user')->insertGetId(
            ['assignment_id' => $request->assignment, 'user_id'=>Auth::user()->id, 'score'=>90]
        );
        $assignment = Assignment::find($request->assignment);
        $sections = $assignment->sections;
        $studentAnswers = $request->studentAnswers;
        foreach ($sections as $key=>$section) {
            $questions = $section->questions;
            foreach($questions as $qKey =>$question){
                DB::table('question_user')->insert(
                ['assignment_user_id' =>  $assignmentId, 'question_id'=>$question->id, 'user_answer'=>$studentAnswers[$key][$qKey+1]]
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
