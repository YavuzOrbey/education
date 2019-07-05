<nav>
    <ul>
      <li><a href="/">Home</a></li>
      <li><a href="{{route('assignments.index')}}">Assignments</a></li>
      @guest
      <li class="nav-item">
        <a href="{{ route('login') }}" id="show-login">Login</a>
      </li>

      @if (Route::has('register'))
      <li class="nav-item">
        <a  href="{{ route('register') }}" id="show-register">{{ __('Register') }}</a>
      </li>
      @endif

      @endguest
    </ul>
    <div class="nav-profile">
        <ul class="navbar-nav ">
                
                @auth
                <li class="nav-item dropleft ">
                  <a class="nav-link dropdown-toggle"  href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{ Auth::user()->last_name }}
                  </a>
                  
                  <div class="dropdown-menu w-auto" aria-labelledby="navbarDropdown">
                    <!-- <a class="dropdown-item" href="{{route('admin.dashboard')}}">Dashboard</a> -->
                    {{-- <a class="dropdown-item" href="{{route('profile', ['username' => Auth::user()->username])}}">My Profile</a> --}}
                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                      {{ __('Logout') }}
                    </a>
                    
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                      @csrf
                    </form>
                  </div>
                </li>
                @endauth
          
              </ul>
    </div>
</nav>