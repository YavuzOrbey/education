<div id="loginModal" class="modal ">
        <div class="modal-content-auth">
                <div class="closeBtn"></div>
            <div class="modal-body-auth">
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
                        <input type="password" name="password" class="input-control{{ $errors->has('password') ? ' is-invalid' : '' }}" id="password" required>
                        @if ($errors->has('password'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                        @endif
                    </div>
                
                    <div class="input-group auth-group">
                        <div>
                            <input type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">{{ __('Remember Me') }}</label>
                        </div>
                        <button type="submit" class="btn auth-btn">{{ __('LOGIN') }}</button>
                        <div class='login-additional'>
                                <a href="{{ route('register') }}">{{ __('Sign Up') }}</a>
                                
                                @if (Route::has('password.request'))
                                <a  href="{{ route('password.request') }}">
                                {{ __('Forgot Your Password?') }}
                                </a>
                                @endif
                        </div>
                    </div>
                            
                    
                </form>
                    
            </div>
            
        </div>
    </div>