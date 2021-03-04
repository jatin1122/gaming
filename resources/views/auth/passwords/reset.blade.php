@extends('layouts.app')

@section('background-image', asset('images/main-background.jpg'))

@section('content')


<div>

    <div class="container">
        
        <div class="login-container">

            <div class="tac col-xs-12 col-lg-8">
                <form method="POST" action="{{ route('password.request') }}" aria-label="Set passwords">
                    @csrf

                    <h2>Set a new password</h2>

                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                        <input type="hidden" name="token" value="{{ $token }}" />
                        @include('components.baseInput', [
                            'name' => 'email',
                            'label' => 'Email',
                            'type' => 'text',
                            'required' => true,
                        ])
                        @include('components.baseInput', [
                            'name' => 'password',
                            'label' => 'Password',
                            'type' => 'password',
                            'required' => true,
                        ])
                        @include('components.baseInput', [
                            'name' => 'password_confirmation',
                            'label' => 'Confirm Password',
                            'type' => 'password',
                            'required' => true,
                        ])
                        <div class="tac">
                            <button type="submit" class="btn btn-white">
                                Set password
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
        </div>
        <!-- /.login-container__panel -->

    </div>
    <!-- /.container -->
</div>

@endsection

