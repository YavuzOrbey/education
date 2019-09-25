<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Subject;
use Illuminate\Support\Facades\Validator;
class QuizController extends Controller
{
    public function index(){
       $subjects = Subject::all();
       return view('quiz.index', compact('subjects'));
    }

    public function submit(Request $request){
        //find the quiz that's being submitted
        //user and quiz submission

        $rules = [
            'answers' => 'required|array',
            'answers.*' => 'numeric|nullable'
        ]; 
        $validator = Validator::make($request->all(), $rules);
        if($validator->passes()){
            return 1;
        }
        else{
            return 0;
        }
        /* $validator = Validator::make($request->all(), [
            'questionText' => 'required|max:10',
            'subjectId' => 'required|email',
        ]); */
        //user and 
    }
}
