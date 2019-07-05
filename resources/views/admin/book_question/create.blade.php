@extends('layouts.admin')

@section('content')

    {!! Form::open(['route' => 'book_questions.store', 'data-parsley-validate'=>'']) !!}


    {{Form::label('test_number', 'Test:') }}
    {{Form::select('test_number', $assignments, null, ['class'=>'form-control', 'placeholder'=>'Test', 'required'=>''])}}

    {{Form::label('subject', 'Section:') }}
    {{Form::select('subject', $sections, null, ['class'=>'form-control', 'placeholder'=>'Section', 'required'=>''])}}
    
    {{Form::label('question', 'Question:') }}
    {{Form::number('question', $questionNum) }}

  {{Form::label('correct_answer', 'Correct Answer:') }}
  {{Form::select('correct_answer', $answers, null, ['class'=>'form-control', 'placeholder'=>'Enter an answer', 'required'=>'', 'autofocus'=>'autofocus', 'onfocus'=>"this.select()", 'onmouseup'=>"return false"])}}
  
  {{Form::submit('Create', ['class'=>'btn btn-primary btn-lg btn-block', 'style'=> 'margin-top: 20px']) }}
  
  {!! Form::close() !!}
@stop

@section('scripts')
{{Html::script('js/parsley.min.js') }}
<script src='https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.5/latest.js?config=TeX-MML-AM_CHTML' async></script>
@stop

@section('stylesheets')
{{Html::style('css/admin.css') }}
@stop