@extends('layouts.main')
@section('stylesheets')
{{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css" rel="stylesheet"/> --}}
<link href="https://fonts.googleapis.com/css?family=Alex+Brush" rel="stylesheet">

<style>
        
.page {
    display: none;
    padding: 0 0.5em;
    margin-top: 100px;
}
.page h1 {
    font-size: 2em;
    line-height: 1em;
    margin-top: 1.1em;
    font-weight: bold;
}
.page p {
    font-size: 1.5em;
    line-height: 1.275em;
    margin-top: 0.15em;
}

#loading {
    display: block;
    position: absolute;
    top: 0;
    left: 0;
    z-index: 100;
    width: 100vw;
    height: 100vh;
    background-color: rgba(192, 192, 192, 0.5);
    background-image: url("https://i.stack.imgur.com/MnyxU.gif");
    background-repeat: no-repeat;
    background-position: center;
}
#app > div{
    position: relative;
}
        </style>
@stop
@section('content')
        <div id="app" class="page"></div>
        <div id="loading"></div>
@stop
@section('scripts')
        <script src="{{ asset('js/app.js') }}"></script>
@stop