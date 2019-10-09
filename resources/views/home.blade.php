@extends('layouts.main')


@section('welcome')
@auth <div style="color:white; font-size: 1.3em; margin-left: 10px; font-weight: 600">Welcome {{Auth::user()->first_name}} </div>@endauth
@stop
@section('content')

                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div style="grid-area: content; margin-top: 20px">
                    Hey guys here’s how this works:
                    <p>Register for an account with the group ID number that I assigned at the start of class. You need this number to register for the site! </p>
                    <!--<p>Afterwards (and every time you log in) you’ll be sent to your dashboard. Here you can do things like check which assignments you’ve recently submitted as well as change information in your profile.</p>  -->
                    <p>Each assignment will have an associated pdf. Just click the name or the pdf icon to download it. When you’re ready input your answers and you should have instant feedback</p>
                    </div>
@endsection
