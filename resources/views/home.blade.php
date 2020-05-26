@extends('layouts.main')
@section('stylesheets')
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600&display=swap" rel="stylesheet">
@stop

@section('welcome')
@auth <div style="color:white; font-size: 1.3em; margin-left: 10px; font-weight: 600">Welcome {{Auth::user()->first_name}} </div>@endauth


<div class="banner">
    <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
          <div class="carousel-item active">
              <div class='row  justify-content-around'>
                  <div class='col-12 col-md-5'><img class="d-block img-fluid" src="{{asset('images/assignment.png')}}" alt="First slide"></div>
                  <div class='col-12 col-md-5 carousel-item-description'>
                    <div class='carousel-item-number'>1</div>
                    <div class='carousel-item-description-text'><span>Read and work through assignments</span></div>
                  </div>
              </div>
          </div>
          <div class="carousel-item">
                <div class='row  justify-content-around'>
                    <div class='col-12 col-md-5'> <img class="d-block img-fluid" src="{{asset('images/submit.png')}}" alt="Second slide"></div>
                    <div class='col-12 col-md-5 carousel-item-description'>
                      <div class='carousel-item-number'>2</div>
                      <div class='carousel-item-description-text'><span>When you're ready submit your answers to the assignment</span></div>
                    </div>
                </div>
          </div>
          <div class="carousel-item">
            <div class='row  justify-content-around'>
                <div class='col-12 col-md-5'> <img class="d-block img-fluid" src="{{asset('images/results.png')}}" alt="Second slide"></div>
                <div class='col-12 col-md-5 carousel-item-description'>
                  <div class='carousel-item-number'>3</div>
                  <div class='carousel-item-description-text'><span>Get instant results</span></div>
                </div>
            </div>
          </div>
          <div class="carousel-item">
            <div class='row  justify-content-around'>
                <div class='col-12 col-md-5'> <img class="d-block img-fluid" src="{{asset('images/quiz.png')}}" alt="Second slide"></div>
                  <div class='col-12 col-md-5 carousel-item-description'>
                    <div class='carousel-item-number'>4</div>
                    <div class='carousel-item-description-text'><span>For an extra challenge try some of the quizzes</span></div>
                  </div>
            </div>
            </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>
    </div>
    
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
