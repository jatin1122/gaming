
@extends('layouts.main')
@section('body')
    <div id="app" class="app" style="background-image: url(@yield('background-image'))">

        <div id="starshine">
            <div class="template shine"></div>
        </div>
        
        <a href="/" class="app-logo">
            <img width="258" height="78" src="{{ asset('images/logo.png') }}" alt="Genie Gaming Logo">
        </a>
        <!-- /.app-logo -->

        @yield('content')

    </div>

@endsection



{{-- @guest
    <a href="{{ route('login') }}">{{ __('Login') }}</a>
    <a href="{{ route('register') }}">{{ __('Register') }}</a>
@else
    {{ Auth::user()->username }} <span class="caret"></span>
    <a class="dropdown-item" href="{{ route('logout') }}">
        {{ __('Logout') }}
    </a>
@endguest --}}