@extends('layouts.account')

@section('title', 'Funds')

@section('panel')

    <div class="fund-icons">

        <a class="fund-icon fund-icon--primary" href="/account/funds/deposit">
            @icon('deposit')
            Make a deposit
        </a>
        <a class="fund-icon fund-icon--secondary" href="/account/funds/withdraw">
            @icon('withdrawal')
            Make a withdrawal
        </a>

    </div>
    <!-- /.fund-icons -->
        
@endsection