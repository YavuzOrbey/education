@extends('layouts.main')

@section('content')
@include('inc._messages')
<div style="grid-area: content">

<h3 class="quiz-category" style="border-bottom: 1px lightgrey solid; width: 300px;">Test Prep</h3>
<div class="quiz-selection">
@foreach($subjects as $subject)

    <div class="quiz">
        <a href="/quizzes/{{$subject->id}}">
            <div class="quiz-header">{{$subject->name}}</div>
            <div class='quiz-icon'>
                @if($subject->icon)<i class="{{$subject->icon}}"></i>
                @else
                <span style="font-size: 16px">No Image</span>
                @endif
            
            </div>
        </a>
    </div>

@endforeach
</div>
</div>
@stop

@section('stylesheets')
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
<link href="{{asset('css/quizzes/index.css')}}" rel="stylesheet" type="text/css"/>
@stop