@extends('layouts.admin')
@section('stylesheets')
{{Html::style('css/admin.css') }}
@stop


@section('content')
<h1>Group: {{$group->name}}</h1>
<table class='admin-table table table-striped table-bordered'>
    <thead>
        <tr>
            <th>ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Last Sign-In</th>
            @foreach($group->assignments as $assignment)
            <th>{{$assignment->name}}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
    @foreach($group->users()->orderBy('last_name', 'asc')->get() as $user)
    
    <tr>
        <td ><a href='{{route('admin.users.show', $user)}}'>{{$user->id}}</a></td>
        <td>{{$user->first_name}}</td>
        <td>{{$user->last_name}}</td>
        <td>{{$user->email}}</td>
    
        <td>{{ $user->last_login ? date("n/j  H:i", strtotime($user->last_login)-4*60*60): ""}}</td> 
        @foreach($group->assignments as $assignment)
        <td>
            @if($user->assignments->where('id',$assignment->id)->first())
            <a href='{{route('admin.users.assignment', ['user'=>$user->id, 'assignment'=>$assignment->id])}}'>
                {{$user->assignments->where('id',$assignment->id)->first()->pivot->score . "%"}}
            </a>
            @endif
        </td>

        @endforeach
    </tr>
    
    @endforeach
    </tbody>
    </table>
@stop