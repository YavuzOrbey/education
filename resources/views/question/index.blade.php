@extends('main')

@section('content')

@foreach($questions as $question)
<a href="{{route('questions.show', $question)}}">{{$question->id}}</a>
@endforeach


@stop

