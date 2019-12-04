@extends('layouts.main')
@if(Auth::user())
@section('content')
<div class="assignments-index">
<div class="test-list">
        @if(count($completed)) <p>You've completed  {{count($completed)}} out of {{count($currentAssignments) + count($pastAssignments)}} assignments</p> @endif
    <h2>Current Assignments</h2>
    
    <ul class="list-group">
        @foreach($currentAssignments as $assignment)
        <li class="list-group-item">
            <a href="{{asset("/pdfs/" . str_replace(' ', '_', strtolower($assignment->name)) . '.pdf')}}">{{$loop->index + 1 . ". " . $assignment->name}}</a>
            
            <div class="right-hand-side">
            <a href="{{asset("/pdfs/" . str_replace(' ', '_', strtolower($assignment->name)) . '.pdf')}}" class="pdf-link" download><i class="fas fa-file-pdf"></i></a>
                <span class='due-date'>DUE: {{date("n/j  H:i", strtotime($assignment->pivot->due_date)-4*60*60) }}</span>
                <span class="result">
                @if(Auth::user() && Auth::user()->assignments()->where('assignments.id', $assignment->id)->exists())
                    <i class='far fa-check-square'></i>
                    @if (file_exists(public_path("/pdfs/" . str_replace(' ', '_', strtolower($assignment->name)) . '_solutions.pdf')))
                    <a href="{{asset("/pdfs/" . str_replace(' ', '_', strtolower($assignment->name)) . '_solutions.pdf')}}" download>Solutions</a> 
                    @endif
                    <a href="{{ route('assignments.results', $assignment->id) }}">Results</a>

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
                <span class='due-date'>DUE: {{date("n/j  H:i", strtotime($assignment->pivot->due_date)-4*60*60) }}</span>
                <span class="result">
                @if(Auth::user() && Auth::user()->assignments()->where('assignments.id', $assignment->id)->exists())
                    @if (file_exists(public_path("/pdfs/" . str_replace(' ', '_', strtolower($assignment->name)) . '_solutions.pdf')))
                    <a href="{{asset("/pdfs/" . str_replace(' ', '_', strtolower($assignment->name)) . '_solutions.pdf')}}" download>Solutions</a> 
                    @endif
                <a href="{{ route('assignments.results', $assignment->id) }}" >Results</a>
                @endif
                </span>
            </div>
        </li>
        @endforeach
    </ul>
</div>
</div>
@stop

@else
@section('content')
<div class="assignments-index">
    <div class="test-list">
    <h2>Log in to view your class's assignments.</h2>
    </div>
</div>
@stop
@endif


@section('stylesheets')
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
@stop