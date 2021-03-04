@extends('layouts.account')

@section('title', 'Make a deposit')
@section('panel')

    @include('account.inc.fundsFormCyberSource', [
        'amountLabel' => 'Amount to deposit',
        'buttonLabel' => 'Deposit Funds'
    ])

@endsection



@push('scripts')
  <script src="{{ config('cybersource.flex_library_url') }}"></script>
  <script>
    // JWK is set up on the server side route for /

    var form = document.querySelector('#payment-form');
    var payButton = document.querySelector('#pay-button');
    var flexResponse = document.querySelector('#flexresponse');
    var expMonth = document.querySelector('#expMonth');
    var expYear = document.querySelector('#expYear');
    var errorsOutput = document.querySelector('#errors-output');

    // the capture context that was requested server-side for this transaction
    var captureContext = '<?php echo $captureContext; ?>'  ;
    console.log(captureContext);

    // custom styles that will be applied to each field we create using Microform
    var myStyles = {
      'input': {
        'font-size': '14px',
        'font-family': 'helvetica, tahoma, calibri, sans-serif',
        'color': '#555'
      },
      ':focus': { 'color': 'blue' },
      ':disabled': { 'cursor': 'not-allowed' },
      'valid': { 'color': '#3c763d' },
      'invalid': { 'color': '#a94442' }
    };

    // setup
    var flex = new Flex(captureContext);
    var microform = flex.microform({ styles: myStyles });
    var number = microform.createField('number', { placeholder: 'Enter card number' });
    var securityCode = microform.createField('securityCode', { placeholder: '•••' });

    number.load('#number-container');
    securityCode.load('#securityCode-container');


    payButton.addEventListener('click', function(e) {
      e.preventDefault();
      var options = {
        expirationMonth: expMonth.value,
        expirationYear: expYear.value
      };
      var innerHTML = payButton.innerHTML;
      payButton.disabled = true;
      payButton.innerHTML = "Processing...";
      microform.createToken(options, function (err, token) {
        if (err) {
          // handle error
          console.error(err);
          errorsOutput.textContent = err.message;
          payButton.disabled = false;
      payButton.innerHTML = innerHTML;
        } else {
          // At this point you may pass the token back to your server as you wish.
          // In this example we append a hidden input to the form and submit it.
          console.log(JSON.stringify(token));
          flexResponse.value = JSON.stringify(token);
          form.submit();
        }
      });
    });
</script>
@endpush

