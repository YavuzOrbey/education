@extends('layouts.main')

@section('content')

                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div>
                    Welcome @auth {{Auth::user()->first_name}} @endauth </div>
                    <div>
                    Hey Folks here’s how this works:
                    Register for an account with the group ID number that I assigned at the start of class. You need this number to register for the site! Afterwards (and every time you log in) you’ll be sent to your dashboard. Here you can do things like check which assignments you’ve recently submitted as well as change information in your profile.  Assignments have an associated pdf just click the name or the pdf icon to download it. When you’re ready input your answers and you should have instant feedback. No more waiting for graded papers!
                    </div>
@endsection
