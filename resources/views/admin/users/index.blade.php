@extends('layouts.admin')
@section('stylesheets')
{{Html::style('css/admin.css') }}
@stop


@section('content')
<table>
<thead>
    <tr>
        <th>ID</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Email</th>
        <th>Group ID</th>
    </tr>
</thead>
<tbody>
@foreach($users as $user)

<tr>
    <td><a href='{{route('admin.users.show', $user)}}'>{{$user->id}}</a></td>
    <td>{{$user->first_name}}</td>
    <td>{{$user->last_name}}</td>
    <td>{{$user->email}}</td>
    <td>{{$user->group->name}}</td>
</tr>

@endforeach
{{ $users->links() }}
</tbody>
</table>
@stop