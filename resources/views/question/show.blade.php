@extends('main')
@section('stylesheets')

<style>
div{
margin: 0;
padding: 0;
border: 0;
font-size: 100%;
font: inherit;
vertical-align: baseline;
}
article{
    font-size: 14px;
    position: relative;
    display: block;
    line-height: 19.6px;
    font-weight: 400;
    font-family: Lato, Helvetica, sans-serif
}
.container-answer{
    display: block;
}
.satDescription{
    padding: 30px 0;
}
ul{
    padding: 0;
}
</style>
@stop
@section('content')
<div class="question-block">
    <div class="question-proper">
        <div class="question-number">{{$question->id}}</div>
        <div class="question-text">{{$question->question_text}}</div>
    <div class="question-choices">
        <div>A: {{$question->answer->choice_a}}</div>
        <div>B: {{$question->answer->choice_b}}</div>
        <div>C: {{$question->answer->choice_c}}</div>
        <div>D: {{$question->answer->choice_d}}</div>
    </div>
</div>
@endsection
@section('title', '| Created Post')

@section('scripts')
{{Html::script('js/parsley.min.js') }}
<script src='https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.5/latest.js?config=TeX-MML-AM_CHTML' async></script>
@endsection