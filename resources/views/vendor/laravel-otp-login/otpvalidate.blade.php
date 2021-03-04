@extends('layouts.app')

@section('background-image', asset('images/main-background.jpg'))

@section('content')


<div>

    <div class="container">
        
        <div class="login-container otp-validate">

            <div class="otp-container__panel">
            <form method="POST" action="{{ route('otp.verify') }}">
                        @csrf

                        <p>{{__("laravel-otp-login::messages.hero_text", ["digit" => config("otp.otp_digit_length", 6)])}}</p>

                        <div class="form-group">
                            <label class="form-label">{{__("laravel-otp-login::messages.one_time_password")}}</label>
                          
                                @include('components.baseInput', [
                                    'name' => 'code',
                                    'required' => true,
                                    'type' => 'password'
                                ])
                            
                            @if ($errors->has('code'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('code') }}</strong>
                            </span>
                            @endif
                        </div>

                        <div class="form-footer">
                            <button type="submit" class="btn btn-primary">{{__("laravel-otp-login::messages.verify_phone_button")}}</button>
                        </div>
                        
                    </form>
                    <div class="text-center mt-4">
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    {{ __('laravel-otp-login::messages.otp_not_received') }}
                                </a>
                        </div>
            </div>
           
            <!-- /.login-container__panel -->
        </div>
        <!-- /.login-container__panel -->

    </div>
    <!-- /.container -->
</div>

@endsection

