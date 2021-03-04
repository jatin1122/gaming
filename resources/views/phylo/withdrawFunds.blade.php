@extends('layouts.app')

@section('background-image', asset('images/main-background.jpg'))

@section('content')

<div>

    <div class="container">

        <div class="phylo-container">

            <div class="phylo-container__panel">
                <form method="POST">
                    @csrf

                    <h2>Withdraw Funds</h2>

                    @include('components.baseInput', [
                        'name' => 'amount',
                        'label' => 'Amount',
                        'type' => 'text',
                        'required' => true,
                    ])
                    @include('components.baseInput', [
                        'name' => 'bank_name',
                        'label' => 'Bank Name',
                        'type' => 'text',
                        'required' => true,
                    ])

                    @include('components.baseInput', [
                        'name' => 'ifsc_code',
                        'label' => 'IFSC Code',
                        'type' => 'text',
                        'required' => true,
                    ])

                    @include('components.baseInput', [
                        'name' => 'account_holder_name',
                        'label' => 'Account Holder Name',
                        'type' => 'text',
                        'required' => true,
                    ])

                    @include('components.baseInput', [
                        'name' => 'account_number',
                        'label' => 'Account Number',
                        'type' => 'number',
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
