@extends('layouts.app')

@section('background-image', asset('images/main-background.jpg'))

@section('content')


<div>

    <div class="container">
        
        <div class="login-container">

            <div class="tac col-xs-12 col-lg-8">
                <form method="POST" action="{{ route('password.email') }}" aria-label="{{ __('Reset Password') }}">
                    @csrf

                    <h2>Reset your password</h2>

                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                        @csrf
                        @include('components.baseInput', [
                            'name' => 'email',
                            'label' => 'Email',
                            'type' => 'email',
                            'required' => true,
                        ])
                        <div class="tac">
                            <button type="submit" class="btn btn-white">
                                Reset password
                            </button>
                            <br>

                            <a class="btn btn-link" href="{{ route('login') }}">
                                Back to sign in
                            </a>
                        </div>
                        <!-- /.tac -->
                </form>
            </div>
            {{-- /.login-container__panel --}}
            {{-- <div class="login-container__panel">
                <h1>New to Genie? Sign up for a free account and join the fun!</h1>
                <div class="tac">
                    <a class="btn btn-primary-solid" href="{{ route('register') }}">Create account</a>
                </div>
                <!-- /.tac -->
            </div>
            <!-- /.login-container__panel --> --}}
        </div>
        <!-- /.login-container__panel -->

    </div>
    <!-- /.container -->
</div>

@endsection

