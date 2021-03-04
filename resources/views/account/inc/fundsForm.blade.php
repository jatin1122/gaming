<div class="verified-payment">
    <img src="{{ asset('images/verified.jpg') }}" alt="">
</div>
<form id="payment-forms" method="post">
    @csrf
    <input type="hidden" value="{{ date('c') }}" id="generation-time">
    <input type="hidden" name="encrypted_data" value="" id="encrypted-data">

    @include('components.baseInput', [
        'name' => 'amount',
        'label' => $amountLabel,
        'required' => true,
        'type' => 'text',
        'placeholder' => $amountPlaceholder ?? null,
        'attributes' => [
        ]
    ])
        @if ($errors->has('card'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('card') }}</strong>
            </span>
        @endif
    
        <div class="new-card-form"  id="new-card-form">
    <h2>Card details</h2>

    @include('components.baseInput', [
        'cse' => true,
        'required' => true,
        'for' => 'cardholder-name',
    ])

    @include('components.baseInput', [
        'name' => "card-number",
        'cse' => true,
        'required' => true,
        'for' => 'card-number',
        'type' => 'tel',
        'attributes' => [
            'maxlength' => '16',
            'data-js-restrict-input' => 'number',
        ]
    ])
    
    <div class="card-security">
        <div class="card-security__expiry">
            <div class="card-security__month">
                @include('components.baseInput', [
                    'cse' => true,
                    'required' => true,
                    'for' => 'expiry-month',
                    'placeholder' => 'MM',
                    'type' => 'tel',
                    'attributes' => [
                        'maxlength' => '2',
                        'data-js-restrict-input' => 'number',
                    ],
                ])
            </div>
            <div class="card-security__year">
                @include('components.baseInput', [
                    'cse' => true,
                    'required' => true,
                    'for' => 'expiry-year',
                    'placeholder' => 'YY',
                    'type' => 'tel',
                    'attributes' => [
                        'maxlength' => '2',
                        'data-js-restrict-input' => 'number',
                    ]
                ])
            </div>
        </div>
        <!-- /.card-security__expiry -->

        <div class="card-security__cvc">
            @include('components.baseInput', [
                'cse' => true,
                'required' => true,
                'for' => 'cvc',
                'label' => 'CVC',
                'placeholder' => 'Field required',
                'type' => 'tel',
                'attributes' => [
                    'maxlength' => '4',
                    'data-js-restrict-input' => 'number',
                ]
            ])
        </div>

    </div>
    <!-- /.card-security-detail-wrapper -->

</div>
<!-- /.new-card-form -->

    <button class="btn btn-primary" type="submit" {{-- disabled --}}>{{ $buttonLabel }}</button>
</form>
