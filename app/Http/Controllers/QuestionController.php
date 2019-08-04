<?php

namespace App\Http\Controllers;

use App\Question;
use App\Subject;
use App\Answer;
use App\AnswerResponse;
use App\Section;
use Illuminate\Http\Request;
use Session;

use Illuminate\Support\Facades\Validator;
class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $questions = Question::all();
       return view('question.index', compact('questions'));

    }
    public function apiIndex(){
    $sentQuestions = [];
    $questions = Question::all();
    
    $answerResponses = AnswerResponse::all()->except(0);
    foreach ($questions as $index=>$question) {
        $currentQuestionObj = new \stdClass();
        $questionTextObj = new \stdClass();
        $questionChoicesObj = new \stdClass();
        $currentQuestionObj->number = $index+1;
        $currentQuestionObj->question_text = $question->question_text;
        /* $questionTextObj->$index = $question->question_text;
        $currentQuestionObj->question = $questionTextObj; */

        $letters = $answerResponses->pluck('letter');
        foreach ($letters as $letter) {
            $column = strtolower('choice_' . $letter);
            $questionChoicesObj->$letter = $question->answer->$column;
        }
        $currentQuestionObj->answer_choices = $questionChoicesObj;
        $sentQuestions[] =$currentQuestionObj;
    }
       return json_encode($sentQuestions, JSON_PRETTY_PRINT);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        /* $subjects = Subject::all();
        $answer_choices = AnswerResponse::all()->except(0);
        //$subjects = $subjects->pluck('name', 'id');
        $answers = $answer_choices->pluck('letter', 'id'); */
        return view('app');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'questionText' => 'required', //Must be a number and length of value is 8
            'subjectId' => 'required|numeric',
            'answerChoices' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);
        /* $validator = Validator::make($request->all(), [
            'questionText' => 'required|max:10',
            'subjectId' => 'required|email',
        ]); */
        if ($validator->passes()) {
            $question = new Question;
            $question->subject_id = $request->subjectId;
            $question->question_text = $request->questionText;
            $question->correct_answer = $request->correctAnswer;
            $question->save();

            $answer = new Answer;
            $answer->choice_a = $request->answerChoices['A'];
            $answer->choice_b = $request->answerChoices['B'];
            $answer->choice_c = $request->answerChoices['C'];
            $answer->choice_d = $request->answerChoices['D'];
            $answer->question_id = $question->id;
            $answer->save();
            return "Question saved!";
        } else {
            //TODO Handle your error
            return "Something went wrong";
        }
        return $data;
        /* $validatedData = $request->validate([
            'questionText' => 'required',
            'subjectId' => 'required',
          ]); */
        $response = array(
            'status' => 'success',
            'msg' => $request['questionText'],
        );
        return response()->json($response); 
        
       

        /* $data = json_decode($request->question, true);
        return $data;
        return gettype($request->data);
  /*       $data = json_decode($request->payload, true); */
        /* $validatedData = $request->validate([
            'subject' => 'bail|required|integer',
            'question'=> 'required',
            'choice_a' => 'required',
            'choice_b' => 'required',
            'choice_c' => 'required',
            'choice_d' => 'required',
            'correct_answer' => 'required|integer'
        ]);  */

        

       
        

        Session::flash('success', 'Question successfully saved');
        return redirect()->route('questions.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
        $answers = [
            'A' => $question->answer->choice_a,
            'B' => $question->answer->choice_b,
            'C' => $question->answer->choice_c,
            'D' => $question->answer->choice_d,
        ];
        
        return view('question.show', compact('question', 'answers'));
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Question $question)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
        //
    }
}
