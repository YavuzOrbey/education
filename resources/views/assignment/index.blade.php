@extends('layouts.main')

@section('content')
<div class="assignments-index">
<div class="test-list">
    <h2>Current Assignments</h2>
    @isset($completed) <p>You've completed  {{count($completed)}} out of {{count($currentAssignments) + count($pastAssignments)}} assignments</p> @endisset
    <ul class="list-group">
        @foreach($currentAssignments as $assignment)
        <li class="list-group-item">
            <a href="{{route('assignments.show', $assignment)}}">{{$loop->index + 1 . ". " . $assignment->name}}</a>
            <span class='due-date'>DUE: {{date("n/j  H:i", strtotime($assignment->due_date)-4*60*60)}}</span>
            @if(Auth::user() && Auth::user()->assignments()->where('assignments.id', $assignment->id)->exists())
            <div class="result">
                <i class='far fa-check-square'></i><a href="{{ route('assignments.results', $assignment->id) }}">Results</a>
            </div>
            @endif
        </li>
        @endforeach
    </ul>
</div>

<div class="test-list">
    <h2>Past Assignments</h2>
    <ul class="list-group">
        @foreach($pastAssignments as $assignment)
        <li class="list-group-item">
        <span>{{$loop->index + 1 . ". " . $assignment->name}}</span>
            @if(Auth::user() && Auth::user()->assignments()->where('assignments.id', $assignment->id)->exists())
                <div class="result">
                    90% <a href="{{ route('assignments.results', $assignment->id) }}">Results</a>
                </div>
            @endif
        </li>
        @endforeach
    </ul>
</div>
</div>
@stop

@section('stylesheets')
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
@stop