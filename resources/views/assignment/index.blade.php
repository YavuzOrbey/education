@extends('main')

@section('content')
<div class="assignments-index">
    <h2>Assignments</h2>
    <ul class="list-group">
        @foreach($assignments as $assignment)
        <li class="list-group-item"><a href="{{route('assignments.show', $assignment)}}">{{$loop->index + 1 . ". " . $assignment->name}}</a></li>
        @endforeach
    </ul>
</div>
@stop