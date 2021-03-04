<div class="new-card-form" {{ $hidden ? 'hidden' : null }} id="new-card-form">
    <h2>Card details</h2>

    @include('components.baseInput', [
        'cse' => true,
        'required' => true,
        'for' => 'cardholder-name',
    ])

    <div class="form-group input">
        <label id="cardNumber-label">Card Number</label>
        <div id="number-container" class="form-control"></div>
    </div>
    <div class="form-group input">
        <label for="securityCode-container">Security Code</label>
        <div id="securityCode-container" class="form-control"></div>
    </div>
    <div class="card-security">
        <div class="card-security__expiry">
            <div class="card-security__month">
                @include('components.baseSelect', [
                    'required' => true,
                    'placeholder_value' => 'MM',
                    'type' => 'tel',
                    'for' => 'expMonth',
                    'name' => 'expiry_month',
                    'options' => [
                        '01' => '1',
                        '02' => '2',
                        '03' => '3',
                        '04' => '4',
                        '05' => '5',
                        '06' => '6',
                        '07' => '7',
                        '08' => '8',
                        '09' => '9',
                        '10' => '10',
                        '11' => '11',
                        '12' => '12'
                    ]
                ])
            </div>
            <div class="card-security__year">
                @include('components.baseSelect', [
                    'cse' => true,
                    'required' => true,
                    'placeholder_value' => 'YY',
                    'type' => 'tel',
                    'for' => 'expYear',
                    'name' => 'expiry_year',
                    'options' => [
                        '2020' => '2020',
                        '2021' => '2021',
                        '2022' => '2022',
                        '2023' => '2023',
                        '2024' => '2024',
                        '2025' => '2025',
                        '2026' => '2026',
                        '2027' => '2027',
                        '2028' => '2028',
                        '2029' => '2029',
                        '2030' => '2030',
                        '2031' => '2031'
                    ]
                ])
            </div>
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
