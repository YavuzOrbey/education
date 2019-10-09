@extends('layouts.admin')
@section('stylesheets')
{{Html::style('css/admin.css') }}
@stop


@section('content')

<div>
    <div>{{$user->id}}: {{$user->first_name . " " . $user->last_name}}</div>
</div>
@stop