<?php

namespace App\Http\Controllers;

use App\Assignment;
use App\Question;
use App\BookQuestion;
use App\Section;
use App\Group;
use App\AssignmentGroup;
use Validator;
use Carbon\Carbon;
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

            $questions = array();
            foreach ($section->questions()->orderBy('pivot_sequence', 'asc')->get() as $index => $question) {
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
    public function list()
    {

        $currentAssignments = []; 
        $pastAssignments=[];
        //get only assignments that aren't practice tests and that have been assigned to the current user's group
        if(Auth::user()){
            $assignments = Auth::user()->group->assignments()->where('name', 'NOT LIKE', '%Practice%')->get();
            //find only assignments that have at least one question in each of their sections
            foreach($assignments as $assignment){
                        foreach($assignment->sections as $section){
                            if(count($section->questions)){
                                if(strtotime($assignment->pivot->due_date) > time()){
                                    array_push($currentAssignments, $assignment);
                                    break;
                                }
                                else{
                                    array_push($pastAssignments, $assignment);
                                    break;
                                }
                            }
                        }
                    }

            usort($currentAssignments, function ($assignment, $key) {
                return $assignment->pivot->due_date;
            });
            usort($pastAssignments, function ($assignment, $key) {
                return $assignment->pivot->due_date;
            });
            /*$pastAssignments = Assignment::find($pastAssignments);
            $pastAssignments = $pastAssignments->sortBy(function ($assignment, $key) {
                return $assignment['due_date'];
            }); */
            $completed= Auth::user()->assignments;
            return view('assignment.index', compact('currentAssignments', 'pastAssignments', 'completed'));
        }
        else{
            return view('assignment.index');
        }
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
        //$assignment->due_date = date("Y-m-d H:i:s", strtotime($request->assignment['due_date']) +60*60*23 +60*59 + 59+4*60*60);
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

        $sections = $assignment->sections;

        $scores = [];
        if(Auth::user() && Auth::user()->hasRole('administrator')){
            foreach($assignment->users as $user){
                array_push($scores, [$user->first_name . " " . $user->last_name, $user->pivot->score]);
            }
            usort($scores, function($a,$b){
                if($a[1]==$b[1]){
                    return 0;
                }
                return  ($a[1] <$b[1]) ? -1:1;
            });
             return view('admin.assignments.show',  compact('assignment', 'scores'));
        }
        else if(Auth::user() && Auth::user()->assignments()->where('assignments.id', $assignment->id)->exists()){
           
            return view('assignment.completed',  compact('assignment'));
        }
            
        else if(Auth::user()  && !empty($sections->all())){
            return view('assignment.show', compact('sections', 'assignment'));
        }
        else{
            return redirect()->route('assignments.list');
        }


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Assignment  $assignment
     * @return \Illuminate\Http\Response
     */

    public function edit(Assignment $assignment){
        return view('admin.assignments.edit', compact('assignment'));
    }

    public function manage(){
        $groups = Group::all()->pluck('name', 'id');
        $assignments = Assignment::all()->filter(function ($value, $key){
            return !strpos($value->name, "Practice");
        })->pluck('name', 'id');
        return view('admin.assignments.manage', compact('assignments', 'groups'));
    }
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
            $keys = array_keys($currentSection->questions);
            $keys = array_map(function($el){
                return Array('sequence'=>$el+1);
            }, $keys );
            $syncData = array_combine($questionIDs, $keys);
            $section = Section::where('assignment_id', $assignment->id)->where('subject_id', $subject_id)->first();
            $section->questions()->sync($syncData);
        }
        $assignment->name = $theData->name;
        $assignment->save();
        return redirect()->route('assignments.show', ['assignment'=>$assignment]);
    }
    public function confirm(Request $request){
        $assignment = Assignment::find($request->assignment);
        $sections = $assignment->sections;
        $studentAnswers = $request->answers;
        $guide = [0=>'',1=>'A', 2=>'B', 3=>'C', 4=>'D'];
        return view('assignment.confirm', compact('assignment', 'studentAnswers', 'guide'));
    }
    public function process(Request $request){

        $assignment = Assignment::find($request->assignment);
        // need the group and assignment id
        $dueDate= AssignmentGroup::where('group_id', Auth::user()->group->id)->where('assignment_id', $assignment->id)->first()->due_date;
        

        if(!Auth::user() || time() > strtotime($dueDate) ){
            abort(401, 'Something went wrong');
        }
        $assignmentUserId = DB::table('assignment_user')->insertGetId(
            ['assignment_id' => $assignment->id, 'user_id'=>Auth::user()->id, 'score'=>0, 'created_at'=>Carbon::now(), 'updated_at'=>Carbon::now()]
        );
        $assignment = Assignment::find($request->assignment);
        $sections = $assignment->sections;
        $studentAnswers = json_decode($request->studentAnswers, true);
        $numRight = 0; $total = 0; $arr = array();
        foreach ($sections as $key=>$section) {
            $questions = $section->questions()->orderBy('pivot_sequence', 'asc')->get();
            $total +=count($questions);
            foreach($questions as $qKey =>$question){
                
                if($question->correct_answer ==$studentAnswers[$key][$qKey+1]){
                    $numRight++;
                }
                DB::table('user_answers')->insert(
                ['assignment_user_id' =>  $assignmentUserId, 'book_question_id'=>$question->id, 'user_answer'=>$studentAnswers[$key][$qKey+1], 'created_at'=>Carbon::now(), 'updated_at'=>Carbon::now()]
                );
            }
        }
        $score = ($numRight/(float) $total) * 100;
       // dd($numRight . " out of " . $total);
        DB::table('assignment_user')->where('id', $assignmentUserId)->update(['score' =>$score]);
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
            $questions = $section->questions()->orderBy('pivot_sequence', 'asc')->get();
            foreach($questions as $qKey =>$question){
                if(Auth::user()){
                    $completedQuestion = DB::table('user_answers')->where('book_question_id', $question->id)->where('assignment_user_id',$completedAssignment->id)->first();
                }

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
