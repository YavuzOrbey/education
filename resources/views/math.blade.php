@extends('layouts.main')

@section('content')

<div class="editable"></div>
@stop


@section('scripts')
{{Html::script('js/parsley.min.js') }}
<script src="{{asset('js/script.js')}}" ></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.5/latest.js?config=TeX-MML-AM_CHTML' async></script>
@stop