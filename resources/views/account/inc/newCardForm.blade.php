<div class="new-card-form" {{ $hidden ? 'hidden' : null }} id="new-card-form">
    <h2>Card details</h2>

    @include('components.baseInput', [
        'cse' => true,
        'required' => true,
        'for' => 'cardholder-name',
    ])

    @include('components.baseInput', [
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
{{--     
    <div class="form-group">
        @include('components.baseCheckbox', [
            'name' => 'save_card',
            'label' => 'Save for future use?',
            'checked' => old('save_card') == 1
        ])
    </div> --}}

</div>
<!-- /.new-card-form -->