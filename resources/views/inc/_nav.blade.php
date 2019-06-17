<nav>
    <ul>
    <li><a href="/">Home</a></li>
    <li><a href="{{route('assignments.index')}}">Assignments</a></li>
    </ul>
    <div class="nav-profile">
{{--         <div class="pic">Picture</div>
        <ul class="dropdown">
            <li>My Profile</li>
        </ul> --}}
        <ul class="navbar-nav ">
                @guest
                <li class="nav-item dropleft">
                  <a class="nav-link dropdown-toggle text-white" href="{{ route('login') }}" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Login
                  </a>
                  
                  <div class="dropdown-menu w-auto @if ($errors->has('email')) show @endif" aria-labelledby="navbarDropdown">
                                    
                    <form class="px-4 py-3" method="POST" action="{{ route('login') }}">
                      @csrf
                      <div class="form-group">
                        <label for="email">{{ __('Email Address') }}</label>
                        <input type="email" name="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" id="email" placeholder="email@example.com" value="{{ old('email') }}" autocomplete="off">
                        
                        @if ($errors->has('email'))
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $errors->first('email') }}</strong>
                        </span>
                        @endif
                      </div>
          
                      <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" id="password" placeholder="Password" >
                        @if ($errors->has('password'))
                          <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('password') }}</strong>
                          </span>
                        @endif
                      </div>
          
                      <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember">
                          {{ __('Remember Me') }}
                        </label>
                      </div>
                      
                      <button type="submit" class="btn btn-primary">{{ __('Login') }}</button>
                    </form>
                                  
                    <div class="dropdown-divider"></div>
                    
                    <a class="dropdown-item btn btn-link" href="{{ route('register') }}">{{ __('Sign up') }}</a>
                    
                    @if (Route::has('password.request'))
                    <a class=" dropdown-item btn btn-link" href="{{ route('password.request') }}">
                      {{ __('Forgot Your Password?') }}
                    </a>
                    @endif
                  </div>
                </li>
                
                @if (Route::has('register'))
                <li class="nav-item">
                  <a class="nav-link text-white" href="{{ route('register') }}">{{ __('Register') }}</a>
                </li>
                @endif
                      
                @else
                <li class="nav-item dropleft ">
                  <a class="nav-link dropdown-toggle"  href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{ Auth::user()->username }}
                  </a>
                  
                  <div class="dropdown-menu w-auto" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{{route('admin.dashboard')}}">Dashboard</a>
                    {{-- <a class="dropdown-item" href="{{route('profile', ['username' => Auth::user()->username])}}">My Profile</a> --}}
                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                      {{ __('Logout') }}
                    </a>
                    
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                      @csrf
                    </form>
                  </div>
                </li>
                @endguest
          
              </ul>
    </div>
</nav>