@extends('layouts.app')

@section('background-image', asset('images/main-background.jpg'))

@section('content')
    
    @include('account.inc.dashboardHeader')

    <div class="dashboard-portal">

        <a class="dashboard-portal__item" href="/account/funds">
            @icon('funds')
            Funds
        </a>
        <a class="dashboard-portal__item" href="/account/history">
            @icon('history')
            History
        </a>
        <a class="dashboard-portal__item" href="/account/settings">
            @icon('settings')
            Account settings
        </a>

    </div>
    <!-- /.dashboard-portal -->

@endsection
