@extends('layouts.main')

@section('content')
<div class="assignments-index">
<div class="test-list">
        @isset($completed) <p>You've completed  {{count($completed)}} out of {{count($currentAssignments) + count($pastAssignments)}} assignments</p> @endisset
    <h2>Current Assignments</h2>
    
    <ul class="list-group">
        @foreach($currentAssignments as $assignment)
        <li class="list-group-item">
            <a href="{{asset("/pdfs/" . str_replace(' ', '_', strtolower($assignment->name)) . '.pdf')}}">{{$loop->index + 1 . ". " . $assignment->name}}</a>
            
            <div class="right-hand-side">
            <a href="{{asset("/pdfs/" . str_replace(' ', '_', strtolower($assignment->name)) . '.pdf')}}" class="pdf-link"><i class="fas fa-file-pdf"></i></a>
                <span class='due-date'>DUE: {{date("n/j  H:i", strtotime($assignment->due_date)-4*60*60)}}</span>
                <span class="result">
                @if(Auth::user() && Auth::user()->assignments()->where('assignments.id', $assignment->id)->exists())
                    <i class='far fa-check-square'></i><a href="{{ route('assignments.results', $assignment->id) }}">Results</a>

                @elseif (Auth::user())
                <a href="{{route('assignments.show', $assignment)}}">Submit</a>
                @endif
                </span>

            </div>
        </li>
        @endforeach
    </ul>
</div>

<div class="test-list">
    <h2>Past Assignments</h2>
    <ul class="list-group">
        @foreach($pastAssignments as $assignment)
        <li class="list-group-item">
            <a href="{{asset("/pdfs/" . str_replace(' ', '_', strtolower($assignment->name)) . '.pdf')}}">{{$loop->index + 1 . ". " . $assignment->name}}</a>
            <div class="right-hand-side">
                <a href="{{asset("/pdfs/" . str_replace(' ', '_', strtolower($assignment->name)) . '.pdf')}}" class="pdf-link"><i class="fas fa-file-pdf"></i></a>
                <span class='due-date'>DUE: {{date("n/j  H:i", strtotime($assignment->due_date)-4*60*60)}}</span>
            @if(Auth::user() && Auth::user()->assignments()->where('assignments.id', $assignment->id)->exists())
                <div class="result">
                    90% <a href="{{ route('assignments.results', $assignment->id) }}">Results</a>
                </div>
            @endif
            </div>
        </li>
        @endforeach
    </ul>
</div>
</div>
@stop

@section('stylesheets')
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
@stop