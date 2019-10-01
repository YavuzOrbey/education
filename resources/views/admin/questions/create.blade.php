@extends('layouts.admin')
@section('stylesheets')
{{Html::style('css/admin.css') }}
@stop


@section('content')
<noscript>
<div class="question-block">
    {!! Form::open(['route' => 'questions.store', 'data-parsley-validate'=>'']) !!}
  <div class="question-proper">

      <div class="question-text">
                  {{Form::label('question_text', 'Question Text:') }}
                  {{Form::textarea('question_text', null, ['class'=>'form-control', 'placeholder'=>'Enter a question', 'required'=>'', 'minlength'=>5] ) }}
      </div>
      <div class="question-subject">
              <div>
          {{Form::label('subject', 'Subject:') }}
          {{Form::select('subject', $subjects, null, ['class'=>'form-control', 'placeholder'=>'Enter a Subject', 'required'=>''])}}
              </div>
      <div></div>
        {{-- <div class="question-tags">
                {{Form::label('Tags', 'Subject:') }}
                {{Form::select('tags', $tags, null, ['class'=>'form-control', 'placeholder'=>'Enter a Subject', 'required'=>''])}}
        </div> --}}
        </div>
  </div>
  <div class='answer-type'>
          ANSWER CHOICES
    <input type="radio" name="answer-type" id="answer-type-1" value="0"><label for="answer-type-1">Multiple Choice</label>
    <input type="radio" name="answer-type" id="answer-type-2" value="1"><label for="answer-type-2">Grid In</label>
  </div>
  <div class="answer-choices">
        <div>
                {{Form::label('choice_a', 'A:') }}
                <div class="answer-choice">
                {{Form::textarea('choice_a', null, ['class'=>'form-control', 'placeholder'=>'Enter answer choice A text here', 'required'=>''] ) }}
                {{Form::hidden('body', null, array('id'=>'hidden-editor', 'required'=>'')) }}
                </div>
        </div>
        <div>
                {{Form::label('choice_b', 'B:') }}
                <div class="answer-choice">
                        {{Form::textarea('choice_b', null, ['class'=>'form-control', 'placeholder'=>'Enter answer choice B text here', 'required'=>'']) }}
                        <section id="editor" class="textarea form-control" contenteditable></section>
                </div>
        </div>
        <div>
                {{Form::label('choice_c', 'C:') }}
                <div class="answer-choice">
                {{Form::textarea('choice_c', null, ['class'=>'form-control', 'placeholder'=>'Enter answer choice C text here', 'required'=>'']) }}
                <section id="editor" class="textarea form-control" contenteditable></section>
                </div>
        </div>
        <div>
                {{Form::label('choice_d', 'D:') }}
                <div class="answer-choice">
                {{Form::textarea('choice_d', null, ['class'=>'form-control', 'placeholder'=>'Enter answer choice D text here', 'required'=>'']) }}
                <section id="editor" class="textarea form-control" contenteditable></section>
                </div>
        </div>
      </div>
                {{Form::label('correct_answer', 'Correct Answer:') }}
                {{Form::select('correct_answer', $answers, null, ['class'=>'form-control', 'placeholder'=>'Enter an answer', 'required'=>''])}}

                {{Form::submit('Create', ['class'=>'btn btn-primary btn-lg btn-block', 'style'=> 'margin-top: 20px']) }}

            {!! Form::close() !!}
</div>
</noscript>
<div id="app" ></div>
@stop

@section('scripts')
<script src="{{ asset('js/app.js') }}"></script>
{{Html::script('js/parsley.min.js') }}
<script src='https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.5/latest.js?config=TeX-MML-AM_CHTML' async></script>
@stop