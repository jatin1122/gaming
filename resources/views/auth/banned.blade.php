@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Banned') }}</div>

                <div class="card-body">
                    <p>Sorry, you have been banned for the following reason: {{ $user->ban_reason }}</p>

                    <p>Please contact support</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
