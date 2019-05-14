@extends('main')

@section('content')

    {!! Form::open(['route' => 'book_questions.store', 'data-parsley-validate'=>'']) !!}

    {{Form::label('test_number', 'Test Number:') }}
    {{Form::select('test_number', $tests, null, ['class'=>'form-control', 'placeholder'=>'Test', 'required'=>''])}}

    {{Form::label('subject', 'Section:') }}
    {{Form::select('subject', $sections, null, ['class'=>'form-control', 'placeholder'=>'Section', 'required'=>''])}}
    
    {{Form::label('question', 'Question:') }}
    {{Form::number('question') }}


  {{Form::label('correct_answer', 'Correct Answer:') }}
  {{Form::select('correct_answer', $answers, null, ['class'=>'form-control', 'placeholder'=>'Enter an answer', 'required'=>''])}}
  
  {{Form::submit('Create', ['class'=>'btn btn-primary btn-lg btn-block', 'style'=> 'margin-top: 20px']) }}
  
  {!! Form::close() !!}
@stop

@section('scripts')
{{Html::script('js/parsley.min.js') }}
<script src='https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.5/latest.js?config=TeX-MML-AM_CHTML' async></script>
@stop