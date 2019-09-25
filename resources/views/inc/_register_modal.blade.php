<div id='register-modal' class='modal '>
        <div class="modal-content-auth">
                <div class="closeBtn"></div>
            <div class="modal-body-auth">
                    <form method="POST" action="{{ route('register') }}" class="px-4 py-3">
                    @csrf
                    <div class="input-group">
                        <label for="first_name">{{ __('First Name') }}</label>
                        <div class="col-md-6">
                            <input id="first_name" type="text" class="input-control{{ $errors->has('first_name') ? ' is-invalid' : '' }}" name="first_name" value="{{ old('first_name') }}" 
                            required autofocus autocomplete>
                            @if ($errors->has('first_name'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('first_name') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="input-group">
                        <label for="last_name" >{{ __('Last Name') }}</label>
                        <div class="col-md-6">
                            <input id="last_name" type="text" class="input-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}" name="last_name" value="{{ old('last_name') }}" required autofocus>
                            
                            @if ($errors->has('last_name'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('last_name') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                                        
                    <div class="input-group">
                        <label for="register-email" >{{ __('E-Mail') }}</label>
                
                        <div class="col-md-6">
                            <input id="register-email" type="email" class="input-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>
                
                            @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="input-group">
                            <label for="group_id" >{{ __('Group ID') }}</label>
                            <div class="col-md-6">
                                <input id="group_id" type="text" class="input-control{{ $errors->has('group_id') ? ' is-invalid' : '' }}" name="group_id" value="{{ old('group_id') }}" required autofocus>
                                
                                @if ($errors->has('group_id'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('group_id') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                    <div class="input-group">
                        <label for="register-password" >{{ __('Password') }}</label>
                
                        <div class="col-md-6">
                            <input id="register-password" type="password" class="input-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required autocomplete>
                
                            @if ($errors->has('password'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                
                    <div class="input-group">
                        <label for="password-confirm" >{{ __('Confirm Password') }}</label>
                
                        <div class="col-md-6">
                            <input id="password-confirm" type="password" class="input-control" name="password_confirmation" required autocomplete>
                        </div>
                    </div>
                
                    <div class="input-group auth-group">
                        <button type="submit" class="btn btn-block auth-btn">
                        {{ __('Register') }}
                        </button>
                    </div>
                    </form>
                </div>
        </div>
    </div>