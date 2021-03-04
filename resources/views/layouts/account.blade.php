@extends('layouts.app')

@section('background-image', asset('images/main-background.jpg'))

@section('content')
    


    @include('account.inc.dashboardHeader')


    <div class="container">
    <div class="account-container">
        <div class="account-navigation">
            <a class="account-navigation__item @activeLink('account-funds')" href="/account/funds">
                @icon('funds')
                Funds
            </a>
            <a class="account-navigation__item @activeLink('account-history')" href="/account/history">
                @icon('history')
                History
            </a>
            <a class="account-navigation__item @activeLink('account-settings')" href="/account/settings">
                @icon('settings')
                Settings
            </a>
        </div>
        <!-- /.account-navigation -->

        <div class="account-title">
            @yield('title')
        </div>
        <!-- /.account-title -->

        <div class="account-panel">

            @yield('panel')

        </div>
        <!-- /.account-panel -->
    </div>
    <!-- /.account-container -->
    </div>
    <!-- /.container -->



@endsection
