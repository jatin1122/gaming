@extends('layouts.account')

@section('title', 'Make a deposit')
@section('panel')

    @include('account.inc.fundsForm', [
        'amountLabel' => 'Amount to deposit',
        'buttonLabel' => 'Deposit Funds'
    ])
        
@endsection



@push('scripts')
  <script src="{{ config('payment.cse_library_url') }}"></script>
  <script>
    window.CSE_PUBLIC_KEY = "{{ config('payment.cse_public_key') }}"
  </script>
@endpush

