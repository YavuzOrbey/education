@extends('layouts.main')

@section('content')
@include('inc._messages')
<div style="grid-area: content">
<h3 class="quiz-category" style="border-bottom: 1px lightgrey solid; width: 300px;">Test Prep</h3>
<div class="">
@foreach($quizzes as $quiz)

<a href="/quizzes/{{$quiz->id}}"><div class="">{{$quiz->name}}</div></a>

@endforeach
</div>
</div>
@stop

@section('stylesheets')
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
<link href="{{asset('css/quizzes/index.css')}}" rel="stylesheet" type="text/css"/>
@stop