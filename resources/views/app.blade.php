@extends('layouts.main')
@section('content')
        <div id="app" ></div>
@stop
@section('scripts')
        <script src="{{ asset('js/app.js') }}"></script>
        <script src='https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.5/latest.js?config=TeX-MML-AM_CHTML' async></script>
@stop