<nav class="navbar navbar-expand-lg navbar-light">
    <div class="w-100 text-right">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
    </div>

          <div class="collapse navbar-collapse flex-grow-1 text-right" style="background:white" id="navbarSupportedContent">
          <ul class="navbar-nav ml-auto flex-nowrap">
            <li class="nav-item {{Request::is('/') ? 'active': ''}}"><a href="/" class="nav-link">Home</a></li>
              <li class="nav-item {{Request::is('assignments') ? 'active': ''}}"><a href="{{route('assignments.list')}}" class="nav-link">Assignments</a></li>
              <li class="nav-item {{Request::is('quizzes') ? 'active': ''}}"><a href="/quizzes" class="nav-link">Quizzes</a></li>
              @guest
              <li class="nav-item">
                <a href="{{ route('login') }}" id="show-login"  class="nav-link">Login</a>
              </li>
        
              @if (Route::has('register'))
              <li class="nav-item">
                  <a href="{{ route('register') }}" id="show-register" class="nav-link">{{ __('Register') }} </a>
              </li>
              @endif
        
              @endguest

              @auth
              <li class="nav-item">
                  <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                      {{ __('Logout') }}
                    </a>
                    
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                      @csrf
                    </form>
                
                <div class="dropdown-menu w-auto" aria-labelledby="navbarDropdown">
                  <!--<a class="dropdown-item" href="{{route('admin.dashboard')}}">Dashboard</a> -->
                  {{-- <a class="dropdown-item" href="{{route('profile', ['username' => Auth::user()->username])}}">My Profile</a> --}}

                </div>
              </li>
              @endauth
            </ul>
          </div>
    
    <div class="nav-profile">
        <ul class="navbar-nav ">
               
          
              </ul>
    </div>
</nav>