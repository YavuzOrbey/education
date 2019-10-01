<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Subject;
use Illuminate\Support\Facades\Validator;
use App\Question;
use App\GridQuestion;
use App\Quiz;
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
            'answers.*' => 'numeric|nullable',
            'id' => 'required|numeric'
        ]; 
        $validator = Validator::make($request->all(), $rules);
        if($validator->passes()){
            return Quiz::find($request->id);
            $answers = $request->answers;
            $multipleChoice = Question::where('subject_id', $request->subject)->get();
            $gridQuestions = GridQuestion::where('subject_id', $request->subject)->get();
            $questions = collect($multipleChoice)->merge($gridQuestions);

            foreach($questions as $index=>$question){
               if(gettype($answers[$index])=='integer'){
                   GridQuestion::where('id', $question->id);
                    return json_encode($question->correct_answer === $answers[$index]);
               }
               else{
                    return json_encode($question->correct_answer === $answers[$index]);
               }
            }
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

    public function getQuiz(){
        
    }
}
