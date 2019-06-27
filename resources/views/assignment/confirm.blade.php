@extends('layouts.main')

@section('content')
<div class="assignments-index">
    <h1>Confirm Answers</h1>
    <h2>{{$assignment->name}}</h2>
    <ul class="list-group">
        <form action="{{route('assignments.process', ['assignment'=>$assignment, 'studentAnswers'=>$studentAnswers])}}" method="POST">
            @csrf
                @foreach($assignment->sections as $section)
                <h5>{{$section->subject->name}}</h5>
                    @foreach($section->questions as $question)
                    <li class="list-group-item">
                      {{$loop->index + 1 . ". " . $guide[$studentAnswers[$loop->parent->index][$loop->index+1]] }}
                    </li>
                    @endforeach
                @endforeach
                
                <button>Confirm Submission</button>
            </form>
            </ul>
        </div>
        @stop