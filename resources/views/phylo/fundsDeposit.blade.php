@extends('layouts.app')

@section('background-image', asset('images/main-background.jpg'))

@section('content')

<div>

    <div class="container">

        <div class="phylo-container">

            <div class="phylo-container__panel">
                <form method="POST" action="{{ config('app.checkout') }}">
                    @csrf

                    <h2>Deposit Funds</h2>

                    @include('components.baseInput', [
                        'name' => 'email',
                        'label' => 'Email',
                        'type' => 'email',
                        'required' => true,
                    ])
                    @include('components.baseInput', [
                        'name' => 'firstname',
                        'label' => 'First Name',
                        'type' => 'text',
                        'required' => true,
                    ])

                    @include('components.baseInput', [
                        'name' => 'lastname',
                        'label' => 'Last Name',
                        'type' => 'text',
                        'required' => true,
                    ])

                    @include('components.baseInput', [
                        'name' => 'phone',
                        'label' => 'Phone',
                        'type' => 'text',
                        'required' => true,
                    ])

                    @include('components.baseInput', [
                        'name' => 'amount',
                        'label' => 'Amount',
                        'type' => 'number',
                        'required' => true,
                    ])

                    @include('components.baseInput', [
                        'name' => 'orderid',
                        'label' => '',
                        'value' => $orderID,
                        'type' => 'hidden',
                        'required' => true,
                    ])
                    @include('components.baseInput', [
                        'name' => 'surl',
                        'label' => '',
                        'value' => $surl,
                        'type' => 'hidden',
                        'required' => true,
                    ])
                    @include('components.baseInput', [
                        'name' => 'furl',
                        'label' => '',
                        'value' => $furl,
                        'type' => 'hidden',
                        'required' => true,
                    ])
                    @include('components.baseInput', [
                        'name' => 'keyvalue',
                        'label' => '',
                        'type' => 'hidden',
                        'value' => $phylokey,
                        'required' => true,
                    ])

                    <div class="tac">
                        <button type="submit" class="btn btn-white">
                            Deposit
                        </button>
                    </div>
                    <!-- /.tac -->
                </form>
            </div>
        </div>
        <!-- /.login-container__panel -->

    </div>
    <!-- /.container -->
</div>

@endsection
