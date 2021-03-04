@extends('layouts.app')

@section('background-image', asset('images/main-background.jpg'))

@section('content')
<div class="container">

    <div class="register-container">
        <a class="register-close" href="/login" title="Back to Login"></a>
        <form method="POST" action="{{ route('register') }}" aria-label="Login">
            @csrf

            <h1>Create your Genie account, it’s quick and easy!</h1>

            <h2><span>Sign in details</span></h2>


            <div class="row">
                <div class="col-xs-12 col-lg-6">
                    @include('components.baseInput', [
                        'name' => 'username',
                        'info' => 'visible to other players',
                        'required' => true,
                    ])
                </div>
                <!-- /.col-xs-12 col-lg-6 -->
                <div class="col-xs-12 col-lg-6">
                    @include('components.baseInput', [
                        'name' => 'password',
                        'type' => 'password',
                        'required' => true,
                    ])
                </div>
                <!-- /.col-xs-12 col-lg-6 -->
            </div>
            <!-- /.row -->

            <div class="row">
                <div class="col-xs-12 col-lg-6">
                    @include('components.baseInput', [
                        'name' => 'email',
                        'info' => 'this is how you will sign in',
                        'type' => 'email',
                        'required' => true,
                    ])
                </div>
                <!-- /.col-xs-12 col-lg-6 -->
                <div class="col-xs-12 col-lg-6">
                    @include('components.baseInput', [
                        'name' => 'confirm_email',
                        'type' => 'confirm_email',
                        'required' => true,
                    ])
                </div>
                <!-- /.col-xs-12 col-lg-6 -->
            </div>

            <div class="row">
                <div class="col-xs-12 col-lg-6">
                    @include('components.baseSelect', [
                        'name' => 'countryCode',
                         'info' => 'Country Code',
                        'default_selection' => '44',
                        'options' => $codes
                    ])
                </div>
                <div class="col-xs-12 col-lg-6">
                    @include('components.baseInput', [
                        'name' => 'phone',
                        'info' => 'Used for phone number verification',
                        'type' => 'text',
                        'required' => true,
                    ])
                </div>
            </div>
            <!-- /.row -->


            <h2><span>Your details</span></h2>

            <p>
                <strong>You must be 18+ years old to create an account.</strong>
                <br>
                If we are unable to verify your age automatically then we will require documents from you.
            </p>

            <div class="row">
                <div class="col-xs-12 col-lg-6">
                    @include('components.baseInput', [
                        'name' => 'first_name',
                        'required' => true,
                    ])
                </div>
                <!-- /.col-xs-12 col-lg-6 -->
                <div class="col-xs-12 col-lg-6">
                    @include('components.baseInput', [
                        'name' => 'last_name',
                        'required' => true,
                    ])
                </div>
                <!-- /.col-xs-12 col-lg-6 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-xs-12 col-lg-6">
                    @include('components.baseInput', [
                        'name' => 'dob',
                        'type' => 'date',
                        'required' => true,
                    ])
                </div>
                <!-- /.col-xs-12 col-lg-6 -->
                <div class="col-xs-12 col-lg-6">
                    @include('components.baseSelect', [
                        'name' => 'country',
                        'default_selection' => 'GB',
                        'options' => $countries
                    ])
                </div>
                <!-- /.col-xs-12 col-lg-6 -->
            </div>
            <!-- /.row -->


            {{-- @include('components.baseCheckbox', [
                'name' => 'newsletter',
                'label' => '<strong>Hear about the latest offers, promotions, features and games by email.</strong>',
                'required' => true,
            ]) --}}

            @include('components.baseCheckbox', [
                'name' => 'terms_and_conditions',
                'label' => '<strong>I confirm that I am 18 years or older and agree to the <a target="_blank" rel="noopener" download href="/terms-and-conditions">Terms & Conditions</a> and <a target="_blank" rel="noopener" href="/privacy-policy">Privacy Policy</a></strong>',
                'required' => true,
            ])

            <!--<div class="checkbox-explainer"></div>-->

            <div class="tac">
                <button type="submit" class="btn btn-primary">
                    Sign me up
                </button>
            </div>
            <!-- /.tac -->

        </form>
    </div>
    <!-- /.register-container -->
</div>
<!-- /.container -->








@endsection
