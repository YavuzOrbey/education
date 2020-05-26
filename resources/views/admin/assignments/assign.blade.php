@extends('layouts.admin')

@section('content')
<div id="content">
    <h2>Manage Assignments </h2>
    <h4>Group:</h4>
    <select id="select-btn">
        <option disabled selected value>Select Group</option>
            @foreach ($groups as $key=>$group)
            <option value="{{$key}}">{{$group}}</option>
            @endforeach
            
    </select>
    <button id="edit-btn">Edit</button>
@stop