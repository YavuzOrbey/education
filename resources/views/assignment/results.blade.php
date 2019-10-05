@extends('layouts.main')
@section('stylesheets')
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
@stop
@section('content')
<div class="assignments-index results">
<h2>{{$assignment->name}}</h2>
<ul class="list-group">
        @foreach($sections as $section)
        <li><h5 class="subject-name">{{$section->subject->name}}</h5>
          <table>
            <thead>
              <tr>
                <th>Number</th>
                <th>Response</th>
                <th>Result</th>
                <th>Answer</th>
              </tr>
            </thead>
            <tbody>
              @foreach($section->questions()->orderBy('pivot_sequence', 'asc')->get() as $question)
              <tr>
                <td>{{ $loop->index + 1 }}</td>
                <td>{!! empty($studentAnswers[$loop->parent->index]) ? " ": $guide[$studentAnswers[$loop->parent->index][$loop->index]]!!} </td>
                <td>{!!$studentAnswers[$loop->parent->index][$loop->index]==$question->correct_answer ? 
                "<i style='color:green' class='fas fa-check'></i>": "<i style='color:red' class='fas fa-times'></i>"!!}</td>
                <td> {{$guide[$question->correct_answer] }}</td>
              </tr>
              @endforeach
            </tbody>
          </table>

           
              
            </li>
            @endforeach
          </ul>
</div>
@stop
