@extends('layouts.admin')
@section('stylesheets')
{{Html::style('css/admin.css') }}
@stop


@section('content')
<form action="{{route('subjects.store')}}" method="POST">
    @csrf
    <label for="">Name</label>
    <input name="subject[name]">
    <label for="">Icon</label>
    <input name="subject[icon]">
    <button>Submit</button>
</form>
@stop