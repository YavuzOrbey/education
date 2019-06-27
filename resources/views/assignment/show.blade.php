@extends('layouts.main')
@section('stylesheets')
{{Html::style('css/test.css')}}
@stop
@section('content')
<div class="assignments-index">
<h2 class='assignment-title'>{{strtoupper($assignment->name)}}</h2>
<ul class="list-group">
<form action="{{route('assignments.confirm', ['assignment'=>$assignment])}}" method="POST">
    @csrf
        @foreach($sections as $section)
        <div class="section">
        <h5 class='section-title'>{{$section->subject->name}}</h5>
        <ul>
            @foreach($section->questions as $question)
            <li class="list-group-item">
              <span class="q-num">{{$loop->index + 1 . ". "}}</span>
                {{-- <ul>
                    <li>A</li>
                    <li>B</li>
                    <li>C</li>
                    <li>D</li>
                </ul> --}}
              <label class="bubble-container">A
                <input type="radio" name="answers[{{$loop->parent->index}}][{{$loop->index+1}}]" value="1">
                <span class="checkmark"></span>
              </label>
              <label class="bubble-container">B
                <input type="radio" name="answers[{{$loop->parent->index}}][{{$loop->index+1}}]" value="2" >
                <span class="checkmark"></span>
              </label>
              <label class="bubble-container">C
                <input type="radio" name="answers[{{$loop->parent->index}}][{{$loop->index+1}}]" value="3" >
                <span class="checkmark"></span>
              </label>
              <label class="bubble-container">D
                <input type="radio" name="answers[{{$loop->parent->index}}][{{$loop->index+1}}]" value="4" >
                <span class="checkmark"></span>
              </label>
              <input type="radio" style="display:none" name="answers[{{$loop->parent->index}}][{{$loop->index+1}}]" value="0" checked="checked">
            </li>
            @endforeach
          </ul>
          </div>
        @endforeach
        <button>Submit</button>
    </form>
    </ul>
</div>
@stop
