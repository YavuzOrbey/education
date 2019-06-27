@extends('layouts.main')

@section('content')
<div class="question-block">
  <div class="question-proper">
    <div class="question-number">
{!! Form::open(['route' => 'questions.store', 'data-parsley-validate'=>'']) !!}

                {{Form::label('subject', 'Subject:') }}
                {{Form::select('subject', $subjects, null, ['class'=>'form-control', 'placeholder'=>'Enter a Subject', 'required'=>''])}}
    </div>
    <div class="question-text">
                {{Form::label('question', 'Question:') }}
                {{Form::textarea('question', null, ['class'=>'form-control', 'placeholder'=>'Enter a question', 'required'=>'', 'minlength'=>5] ) }}
    </div>
  </div>
  <div class="question-choices">
                {{Form::label('choice_a', 'A:') }}
                {{Form::textarea('choice_a', null, ['class'=>'form-control', 'placeholder'=>'A', 'required'=>''] ) }}
                {{Form::hidden('body', null, array('id'=>'hidden-editor', 'required'=>'')) }}
                <section id="editor" class="textarea form-control" contenteditable></section>

                {{Form::label('choice_b', 'B:') }}
                {{Form::textarea('choice_b', null, ['class'=>'form-control', 'placeholder'=>'B', 'required'=>'']) }}
                <section id="editor" class="textarea form-control" contenteditable></section>

                {{Form::label('choice_c', 'C:') }}
                {{Form::textarea('choice_c', null, ['class'=>'form-control', 'placeholder'=>'C', 'required'=>'']) }}
                <section id="editor" class="textarea form-control" contenteditable></section>

                {{Form::label('choice_d', 'D:') }}
                {{Form::textarea('choice_d', null, ['class'=>'form-control', 'placeholder'=>'D', 'required'=>'']) }}
                <section id="editor" class="textarea form-control" contenteditable></section>
  </div>
                {{Form::label('correct_answer', 'Correct Answer:') }}
                {{Form::select('correct_answer', $answers, null, ['class'=>'form-control', 'placeholder'=>'Enter an answer', 'required'=>''])}}

                {{Form::submit('Create', ['class'=>'btn btn-primary btn-lg btn-block', 'style'=> 'margin-top: 20px']) }}

            {!! Form::close() !!}
</div>
@stop

@section('scripts')
{{Html::script('js/parsley.min.js') }}
<script src='https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.5/latest.js?config=TeX-MML-AM_CHTML' async></script>
@stop