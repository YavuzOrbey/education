<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Subject;
class QuizController extends Controller
{
    public function index(){
       $subjects = Subject::all();
       return view('quiz.index', compact('subjects'));
    }
}
