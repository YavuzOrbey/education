@extends('layouts.admin')

@section('content')
<div id="content">
    <h2>Manage Assignments </h2>
    <select id="select-btn">
            @foreach ($assignments as $key=>$assignment)
            <option value="{{$key}}">{{$assignment}}</option>
            @endforeach
            
    </select>
    <button id="edit-btn">Edit</button>
    <div id="assignment-container"></div>
    {{-- <form action="{{route('assignments.update', $assignment)}}" method="PUT">
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
    </form> --}}
</div>
@stop

@section('stylesheets')
{{Html::style('css/admin.css') }}
@stop

@section('scripts')
<script>
let editBtn = document.getElementById('edit-btn'), selectBtn = document.getElementById('select-btn');

editBtn.addEventListener('click', ()=>{
    let xhr = new XMLHttpRequest();
    xhr.open('GET', '/api/assignments/' + selectBtn.value, true);
	xhr.onload = function(e){
        let assignment = JSON.parse(this.responseText);
        let date = new Date(assignment.due_date);
        let container = document.getElementById('assignment-container');
        container.innerHTML = `<div class="assignment-edit">
        <form action="/assignments/${assignment.id}" method="PUT"></form>
        @csrf @method('PUT')
        <label>Name</label>
        <input placeholder='${assignment.name}'>
        <input type='date' value='${date.getFullYear().toString() + '-' + (date.getMonth() + 1).toString().padStart(2, 0) + '-' + date.getDate().toString().padStart(2, 0)}'>
        <button>UPDATE</button>
        </div>`; 



    }

    xhr.send();
});
</script>
@stop