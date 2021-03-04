@extends('layouts.account')

@section('title', 'Account Settings')

@section('panel')

<div class="account-settings-wrapper">


    <form
        action="/account/settings/update"
        class="account-settings-form"
        method="POST"
        enctype="multipart/form-data"
    >
        @csrf
        <div class="profile-image-uploader">
            <div class="profile-preview">
                <img id="profile-preview" src="{{ Auth::user()->profile_image ? Storage::url(Auth::user()->profile_image) : '/images/default.jpg' }}">
            </div>
            <!-- /.profile-preview -->
            <div class="profile-upload-button btn btn-primary btn-slim" id="profile-upload-button">Upload a profile image</div>
            <input name="profile_image" id="profile-upload" type="file" accept="image/*"/ hidden>
        </div>

        <div class="form-group input">
            <h3>Account No: <?= Auth::user()->getAccountNumber() ?></h3>
        </div>

        <!-- /.profile-image-uploader -->
        @include('components.baseInput', [
            'name' => 'first_name',
            'value' => Auth::user()->first_name
        ])
        @include('components.baseInput', [
            'name' => 'last_name',
            'value' => Auth::user()->last_name
        ])
        @include('components.baseInput', [
            'name' => 'email_address',
            'type' => 'email',
            'value' => Auth::user()->email
        ])
        @include('components.baseSelect', [
            'name' => 'country',
            'default_selection' => Auth::user()->country,
            'options' => $countriesArray
        ])
          @include('components.baseSelect', [
            'name' => 'countryCode',
            'label' => 'Country Code',
            'default_selection' => Auth::user()->countryCode,
            'options' => $codes
        ])
        @include('components.baseInput', [
            'name' => 'phone',
            'label' => 'Phone Number',
            'type' => 'text',
            'value' => Auth::user()->phone
        ])
        @include('components.baseInput', [
            'name' => 'current_password',
            'label' => 'Current password (if changing password)',
            'type' => 'password',
        ])
        @include('components.baseInput', [
            'name' => 'new_password',
            'label' => 'New password (if changing password)',
            'type' => 'password',
        ])
        @include('components.baseInput', [
            'name' => 'new_password_confirmed',
            'label' => 'Confirm new password (if changing password)',
            'type' => 'password',
        ])
        <button type="submit" class="btn btn-primary-solid btn-slim">
            Save changes
        </button>

    </form>

    <br><br>

    <form class="account-logout-form" action="{{ route('logout') }}" method="POST">
        @csrf
        <button class="btn btn-primary btn-slim">logout</button>
    </form>

</div>
<!-- /.account-settings-wrapper -->
@endsection

