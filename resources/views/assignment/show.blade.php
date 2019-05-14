@extends('main')

@section('content')
<div class="assignments-index">
<h2>{{$assignment->name}}</h2>
<ul class="list-group">
        @foreach($sections as $section)
        <h5>{{$section->subject->name}}</h5>
            @foreach($section->questions as $question)
            <li class="list-group-item">{{$loop->index + 1 . ". " . $question->correctAnswer->letter }}</li>
            @endforeach
        @endforeach
    </ul>
</div>
@stop