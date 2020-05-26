@extends('layouts.admin')
<input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
@section('content')
<div id="content">
    {{Session::has('status') ? Session::get('status'): ""}}
    <h2>Manage Assignments </h2>
    <h4>Group:</h4>
    <select id="select-btn" onchange="chooseGroup()">
        <option disabled selected value>Select Group</option>
            @foreach ($groups as $key=>$group)
            <option value="{{$key}}">{{$group}}</option>
            @endforeach
            
    </select>
    <button id="edit-btn">Edit</button>
    
    <div id="assignment-container"></div><input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
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

//after a group gets chosen show all assignments that have assigned to that group as well as a button that enables the admin to add another assignment
chooseGroup = () =>{
    let xhr = new XMLHttpRequest();
    xhr.open('GET', '/api/groupassignments/' + selectBtn.value, true);
    xhr.onload = function(e){
        let groupAssignments = JSON.parse(this.responseText);
        console.log(groupAssignments);
        let container = document.getElementById('assignment-container');
        container.innerHTML="<h4>Assignments</h4><ul>";
            
        groupAssignments.forEach(groupAssignment => {
            let date = new Date(groupAssignment.due_date);
            container.innerHTML+=`<li>${groupAssignment.assignment.name}
        <form action="/admin/groupassignment/${groupAssignment.id}" method="POST">@csrf @method('PUT')
            <input type='date' value='${date.getFullYear().toString() + '-' + (date.getMonth() + 1).toString().padStart(2, 0) + '-' + date.getDate().toString().padStart(2, 0)}' 
        name='groupAssignment[${groupAssignment.id}]'><button onclick='doSomething()'>SAVE</button></li>`
        });
        container.innerHTML+="</ul>";

    }
    xhr.send();
}

doSomething = () =>{
    console.log(this);
}
/* editBtn.addEventListener('click', ()=>{
    let xhr = new XMLHttpRequest();
    xhr.open('GET', '/api/assignments/' + selectBtn.value, true);
	xhr.onload = function(e){
        let assignment = JSON.parse(this.responseText);
        let date = new Date(assignment.due_date);
        let container = document.getElementById('assignment-container');
        container.innerHTML = `<div class="assignment-edit">
        <form action="/admin/assignments/${assignment.id}" method="POST">
        @csrf @method('PUT')
        <label>Name</label>
        <input placeholder='${assignment.name}' value='${assignment.name}' name='assignment[name]'>
        <input type='date' value='${date.getFullYear().toString() + '-' + (date.getMonth() + 1).toString().padStart(2, 0) + '-' + date.getDate().toString().padStart(2, 0)}' 
        name='assignment[date]'>
        <button>UPDATE</button></form>
        </div>
        `; 



    }

    xhr.send();
}); */

</script>
@stop