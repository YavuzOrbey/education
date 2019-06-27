<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BookQuestion;
use App\Subject;
use App\AnswerResponse;
use App\Assignment;
use App\Section;
use App\SectionQuestion;
use Validator;
class BookQuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $sections = Subject::all()->pluck('name', 'id');
        $answers = AnswerResponse::all()->filter(function ($value, $key){
            return $key > 0;
        })->pluck('letter', 'id');
        $assignments = Assignment::all()->pluck('name', 'id');
        !isset($request->questionNum) ? $questionNum= 1: $questionNum = $request->questionNum;
        return view('admin.book_question.create', compact('sections', 'answers', 'request', 'assignments', 'questionNum'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), 
        ['test_number'=>'required|numeric',
        'subject'=>'required|numeric',
        'question'=>'required|numeric',
        'correct_answer'=>'required'
        ])->validate();

        $section = Section::where('assignment_id', $request->test_number)->where('subject_id', $request->subject)->first();
        $alreadyInserted = $section->questions()->where('question_number', $request->question)->first();
        if ($alreadyInserted) {
            $errors['duplicate'] = 'Section already has that question number';
           return back()->withInput()->withErrors(['Duplicate', 'Section already has question with that number!']);
        }
        
        $question = new BookQuestion;
        $question->question_number = $request->question;
        $question->correct_answer = $request->correct_answer;
        $question->save();
        $questionNum = $question->question_number + 1;
        
        $sectionQuestion = new SectionQuestion;

        $sectionQuestion->section_id = $section->id;
        $sectionQuestion->book_question_id = $question->id;

        $sectionQuestion->save();
        $request->flashOnly('test_number', 'subject');
        return redirect()->route('book_questions.create', ['questionNum'=>$questionNum]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
