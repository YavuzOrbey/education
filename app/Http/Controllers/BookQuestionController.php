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
    public function create()
    {
        $sections = Subject::all()->pluck('name', 'id');
        $tests = Assignment::all()->pluck('name', 'id');
        $answers = AnswerResponse::all()->pluck('letter', 'id');
        return view('book_question.create', compact('tests','sections', 'answers', 'request'));
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

        $question = new BookQuestion;
        $question->question_number = $request->question;
        $question->correct_answer = $request->correct_answer;

        $question->save();

        $section = Section::where('assignment_id', $request->test_number)->where('subject_id', $request->subject)->first();
        $sectionQuestion = new SectionQuestion;

        $sectionQuestion->section_id = $section->id;
        $sectionQuestion->book_question_id = $question->id;

        $sectionQuestion->save();
        $request->flashOnly('test_number', 'subject');
        return redirect()->route('book_questions.create');
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
