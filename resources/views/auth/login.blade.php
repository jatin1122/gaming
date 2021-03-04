@extends('layouts.app')

@section('background-image', asset('images/main-background.jpg'))

@section('content')


<div>

    <div class="container">
        
        <div class="login-container">

            <div class="login-container__panel">
                <form method="POST" action="{{ route('login') }}" aria-label="{{ __('Login') }}">
                    @csrf

                    <h2>Sign into your account</h2>

                    @include('components.baseInput', [
                        'name' => 'email',
                        'label' => 'Email',
                        'type' => 'email',
                        'required' => true,
                    ])
                    @include('components.baseInput', [
                        'name' => 'password',
                        'label' => 'Password',
                        'type' => 'password',
                        'required' => true,
                    ])
                    @include('components.baseCheckbox', [
                        'name' => 'remember',
                        'label' => 'Remember me',
                    ])

                    <div class="tac">
                        <button type="submit" class="btn btn-white">
                            Sign in
                        </button>

                        <a class="btn btn-link" href="{{ route('password.request') }}">
                            Trouble signing in?
                        </a>
                    </div>
                    <!-- /.tac -->
                </form>
            </div>
            {{-- /.login-container__panel --}}
            <div class="login-container__panel">
                <h1>New to Genie? Sign up for a free account and join the fun!</h1>
                <div class="tac">
                    <a class="btn btn-primary-solid" href="{{ route('register') }}">Create account</a>
                </div>
                <!-- /.tac -->
            </div>
            <!-- /.login-container__panel -->
        </div>
        <!-- /.login-container__panel -->

    </div>
    <!-- /.container -->
</div>

@endsection
