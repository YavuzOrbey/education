<div id="theModal" class="modal ">

        <div class="modal-content-auth">
            <div class='modal-header'>                <div class="closeBtn"></div></div>

            <div id='login-content' class="modal-body-auth animate__animated animate__fadeIn">
                <form class="px-4 py-3" method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="input-group">
                        <label for="email">{{ __('Email') }}</label>
                        <input type="email" name="email" class="input-control{{ $errors->has('email') ? ' is-invalid' : '' }}" id="email" value="{{ old('email') }}" autocomplete="off" required>
                                
                        @if ($errors->has('email'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                        @endif
                    </div>
                
                    <div class="input-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" class="input-control{{ $errors->has('password') ? ' is-invalid' : '' }}" autocomplete="off" id="password" required>
                        @if ($errors->has('password'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                        @endif
                    </div>
                
                    <div class="input-group auth-group">
                        <div class='login-helpers row justify-content-around'>
                            <div class='remember-me col-5'>
                                <input type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label for="remember">{{ __('Remember Me') }}</label>
                            </div>
                            <div class='forgot-password col-5'>
                                @if (Route::has('password.request'))
                                <a  href="{{ route('password.request') }}">
                                {{ __('Forgot Your Password?') }}
                                </a>
                                @endif
                            </div>
                        </div>
                        <div class='login-buttons row justify-content-around'>
                            <a class="btn white-btn col-12 col-sm-5 signup-back" id='sign-up' href="{{ route('register') }}">{{ __('SIGN UP') }}</a>
                            <button type="submit" class="btn auth-btn col-12 col-sm-5">{{ __('LOGIN') }}</button>
                        </div>
                    </div>
                            
                    
                </form>
                    
            </div>
            <div id='register-content' class="modal-body-auth animate__animated animate__fadeIn">
                <form method="POST" action="{{ route('register') }}" class="px-4 py-3">
                @csrf
                <div class="input-group">
                    <label for="first_name">{{ __('First Name') }}</label>
                        <input id="first_name" type="text" class="input-control{{ $errors->has('first_name') ? ' is-invalid' : '' }}" name="first_name" value="{{ old('first_name') }}" 
                        required autofocus autocomplete>
                        @if ($errors->has('first_name'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('first_name') }}</strong>
                        </span>
                        @endif
                </div>
                <div class="input-group">
                    <label for="last_name" >{{ __('Last Name') }}</label>
                        <input id="last_name" type="text" class="input-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}" name="last_name" value="{{ old('last_name') }}" required autofocus>
                        
                        @if ($errors->has('last_name'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('last_name') }}</strong>
                        </span>
                        @endif
                </div>
                                    
                <div class="input-group">
                    <label for="register-email" >{{ __('E-Mail') }}</label>
            
                    
                        <input id="register-email" type="email" class="input-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>
            
                        @if ($errors->has('email'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    
                </div>
                <div class="input-group">
                        <label for="group_id" >{{ __('Group ID') }}</label>
                        
                            <input id="group_id" type="text" class="input-control{{ $errors->has('group_id') ? ' is-invalid' : '' }}" name="group_id" value="{{ old('group_id') }}" required autofocus>
                            
                            @if ($errors->has('group_id'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('group_id') }}</strong>
                            </span>
                            @endif
                        
                    </div>
                <div class="input-group">
                    <label for="register-password" >{{ __('Password') }}</label>
            
                    
                        <input id="register-password" type="password" class="input-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required autocomplete>
            
                        @if ($errors->has('password'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    
                </div>
            
                <div class="input-group">
                    <label for="password-confirm" >{{ __('Confirm Password') }}</label>
            
                    
                        <input id="password-confirm" type="password" class="input-control" name="password_confirmation" required autocomplete>
                    
                </div>
            
                <div class="input-group auth-group">
                    <div class='login-buttons row justify-content-around'>
                            <a class="btn white-btn col-12 col-sm-5 login-back" id='sign-up' href="{{ route('login') }}">{{ __('BACK TO LOGIN') }}</a>
                            <button type="submit" class="btn auth-btn col-12 col-sm-5">{{ __('REGISTER') }}</button>
                        </div>

                </div>
                </form>
            </div>
        </div>
    </div>

   {{--  <div id='register-modal' class='modal '>
        <div class="modal-content-auth">
                <div class="closeBtn"></div>
            
        </div>
    </div> --}}