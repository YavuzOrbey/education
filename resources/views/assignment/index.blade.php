@extends('main')

@section('content')
<div class="assignments-index test-list">
    <h2>Assignments</h2>
    @isset($completed) <p>You've completed  {{count($completed)}} out of {{count($assignments)}} assignments</p> @endisset
    <ul class="list-group">
        @foreach($assignments as $assignment)
        <li class="list-group-item">
            <a href="{{route('assignments.show', $assignment)}}">{{$loop->index + 1 . ". " . $assignment->name}}</a>
            @if(Auth::user() && Auth::user()->assignments()->where('assignments.id', $assignment->id)->exists())
            <i class='far fa-check-square'></i><a href="{{ route('assignments.results', $assignment->id) }}">Results</a>
            @endif
        </li>
        @endforeach
    </ul>
</div>
@stop

@section('stylesheets')
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
@stop