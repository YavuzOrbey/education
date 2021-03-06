@extends('layouts.main')

@section('content')
<div class="assignments-index">
    <h1>Confirm answers</h1>
    <p>Check your answers then scroll below and click the red Confirm button!</p>
    <h2>{{$assignment->name}}</h2>
    <ul class="list-group">
        <form action="{{route('assignments.process', ['assignment'=>$assignment])}}" method="POST">
            @csrf
            <input type="hidden" style="display:none" name="studentAnswers" value="{{json_encode($studentAnswers)}}">
                @foreach($assignment->sections as $section)
                <h5>{{$section->subject->name}}</h5>
                    @foreach($section->questions as $question)
                    <li class="list-group-item">
                      {{$loop->index + 1 . ". " . $guide[$studentAnswers[$loop->parent->index][$loop->index+1]] }}
                    </li>
                    @endforeach
                @endforeach
                
                <button class='btn btn-block btn-danger'>Confirm Submission</button>
            </form>
            </ul>
        </div>
        @stop