<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Subject;
use Illuminate\Support\Facades\Validator;
use App\Question;
use App\GridQuestion;
use App\Quiz;
use App\AnswerResponse;
use Illuminate\Support\Collection;
class QuizController extends Controller
{
    public function index(){
       $quizzes = Quiz::all();
       return view('quiz.index', compact('quizzes'));
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
            $results = Array();
            $answers = $request->answers;
            $questions = $this->getQuiz(Quiz::find($request->id), true);
            foreach($questions as $index=>$question){
                $answer = new \stdClass();
                $answer->correct_answer = $question->correct_answer;
                $answer->response = $answers[$index];
                array_push($results, $answer);
            }
            return $results;
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

    public function getQuiz(Quiz $quiz, $answers = false){
        $quiz_questions = $quiz->questions->map(function($question){
            $question['type'] = 0;
            return $question;
        })->concat($quiz->gridQuestions)->map(function($question){
            $question['type'] = 1;
            return $question;
        });
        $quiz_questions = $quiz_questions->sortBy(function($question, $key){
            return $question->pivot->sequence;
        })->values();

        if($answers){
            return $quiz_questions;
        }
        $answerResponses = AnswerResponse::all()->except(0);
        foreach ($quiz_questions as $index=>$question) {
            $currentQuestionObj = new \stdClass();
            $questionTextObj = new \stdClass();
            $questionChoicesObj = new \stdClass();
            $currentQuestionObj->number = $index+1;
            $currentQuestionObj->question_text = $question->question_text;

            if($question->answer){ // current question is a MC question
                $letters = $answerResponses->pluck('letter');
                foreach ($letters as $letter) {
                    $column = strtolower('choice_' . $letter);
                    $questionChoicesObj->$letter = $question->answer->$column;
                }
                $currentQuestionObj->answer_choices = $questionChoicesObj;
            } 
            else{ // It is a grid question
                //$currentQuestionObj->correct_answer = $question->correct_answer;
            }
            $currentQuestionObj->related_content = $question->related_content_id;
    
            $sentQuestions[] =$currentQuestionObj;
        }
        return $sentQuestions;
    }

    public function create()
    {
        $gridQuestions = GridQuestion::all();
        $questions = Question::all();
        dd($questions);
        return view('admin.quizzes.create', compact('subjects', 'answers'));
    }
}
