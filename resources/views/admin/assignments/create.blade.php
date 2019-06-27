@extends('layouts.admin')

@section('content')
<div id="content">
    <h2>Create Assignment </h2>
    <form action="{{route('assignments.store')}}" method="POST">
        @csrf
        <input type="text" name="assignment[name]">
        <input type="date" name="assignment[due_date]">
        <label>Subjects</label>
        <select multiple name="subjects[]">
            <option value="1">SAT Critical Reading</option>
            <option value="2">SAT Writing and Language</option>
            <option value="3">SAT Math No Calc</option>
            <option value="4">SAT Math Calc</option>
        </select>
        <input type="submit">
    </form>
</div>
@stop

@section('stylesheets')
{{Html::style('css/admin.css') }}
@stop