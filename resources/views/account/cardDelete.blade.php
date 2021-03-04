@extends('layouts.account')

@section('title', 'Delete Card')
@section('panel')

    <form id="payment-form" method="post">
      @csrf

      <input type="hidden" value="{{ date('c') }}" id="generation-time">
      <input type="hidden" name="encrypted_data" value="" id="encrypted-data">

      <p>Are you sure you want to delete your active payment method?</p>

      <p>Your account balance of <strong>{{ currency(Auth::user()->getBalance()) }}</strong> will be automatically withdrawn to this card.</p>

      <div class="existing-card-verification" id="existing-card-verification">
          @include('components.baseInput', [
              'cse' => true,
              'for' => 'existing-cvc',
              'label' => 'CVC',
              'placeholder' => 'Field required',
              'required' => true,
              'type' => 'tel',
              'attributes' => [
                  'maxlength' => '4',
                  'data-js-restrict-input' => 'number',
              ]
          ])
      </div>

      <button type="submit" class="btn btn-primary-solid btn-slim">Delete Card</button>

      <a href="/account/funds" class="btn btn-primary btn-slim">Cancel</a>
    </form>

@endsection

@push('scripts')
  <script src="{{ config('payment.payout.store.cse_library_url') }}"></script>
  <script>
    window.CSE_PUBLIC_KEY = "{{ config('payment.payout.store.cse_public_key') }}"
  </script>
@endpush
