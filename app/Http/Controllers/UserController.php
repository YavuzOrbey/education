<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Assignment;
use Illuminate\Support\Facades\DB;
class UserController extends Controller
{
    public function index(){
        $users = User::paginate(20);
        return view('admin.users.index', compact('users'));
    }

    public function show(User $user){
        return view('admin.users.show', compact('user'));
    }

    public function getUserAssignment(User $user, Assignment $assignment){

        $completedAssignment = DB::table('assignment_user')->where('assignment_id', $assignment->id)->where('user_id', $user->id)->first();
        if(!$completedAssignment){
            abort(404);
        }

        $sections = $assignment->sections;
        $studentAnswers = array();
        foreach ($sections as $key=>$section) {
            $studentAnswers[$key] = array();
            $questions = $section->questions()->orderBy('pivot_sequence', 'asc')->get();
            foreach($questions as $qKey =>$question){
                if($user){
                    $completedQuestion = DB::table('user_answers')->where('book_question_id', $question->id)->where('assignment_user_id',$completedAssignment->id)->first();
                }
                if($completedQuestion){
                array_push($studentAnswers[$key], $completedQuestion->user_answer);
                }
            }
        }
        $guide = [0=>'',1=>'A', 2=>'B', 3=>'C', 4=>'D'];
        return view('assignment.results', compact('assignment', 'user', 'sections', 'studentAnswers', 'guide'));

    }
}
