@extends('layouts.account')

@section('title', 'Make a withdrawal')
@section('panel')
    {{-- <br> --}}
    {{-- <strong>Total Winnings: </strong> {{ Auth::user()->getTotalWinnings() }} --}}

    @include('account.inc.fundsForm', [
        'amountLabel' => 'Amount to withdraw',
        'amountPlaceholder' => Auth::user()->getWithdrawableFunds() . ' available to withdraw',
        'buttonLabel' => 'Withdraw Funds'
    ])
        
@endsection



@push('scripts')
  <script src="{{ config('payment.payout.store.cse_library_url') }}"></script>
  <script>
    window.CSE_PUBLIC_KEY = "{{ config('payment.payout.store.cse_public_key') }}"
  </script>
@endpush

