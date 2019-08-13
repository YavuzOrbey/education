@extends('layouts.main')

@section('content')
@include('inc._messages')
<div style="grid-area: content">
<h2>Quizzes</h2>

<h3>Subjects</h3>
@foreach($subjects as $subject)
<a href="/exercises/{{$subject->id}}">{{$subject->name}}</a>
@endforeach
</div>
@stop

@section('stylesheets')
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
@stop