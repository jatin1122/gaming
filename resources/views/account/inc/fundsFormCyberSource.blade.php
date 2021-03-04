<div class="verified-payment">
    <img src="{{ asset('images/verified.jpg') }}" alt="">
</div>
<form id="payment-form" method="post">
    @csrf
    <input type="hidden" value="{{ date('c') }}" id="generation-time">

    @include('components.baseInput', [
        'name' => 'amount',
        'label' => $amountLabel,
        'required' => true,
        'type' => 'text',
        'placeholder' => $amountPlaceholder ?? null,
        'attributes' => [
        ]
    ])

    @if (! $cards->isEmpty())
        <div class="input">
            <label>Payment Method</label>
        </div>
        <!-- /.input -->
        @foreach ($cards as $card)
        <div class="existing-card-radio">
            <input
                name="card"
                type="radio"
                id="{{ $card->getReference() }}"
                value="{{ $card->getReference() }}"
                {{-- {{ old('card') == $card->getReference() ? 'checked' : ''}} --}}
                checked
            >
            <label for="{{ $card->getReference() }}" class="existing-card-radio__label">
                <div class="existing-card-radio__marker"></div>
                <!-- /.existing-card-radio__marker -->
                <div class="existing-card-radio__brand">
                    <img src="{{ asset('images/cards/'. $card->getBrand() .'.png') }}" alt="{{ ucfirst($card->getBrand()) }}">
                </div>
                <!-- /.existing-card-radio__brand -->
                <div class="existing-card-radio__info">
                    <div class="existing-card-radio__name">
                        {{ $card->getName() }}
                    </div>
                    <!-- /.existing-card-radio__name -->
                    <div class="existing-card-radio__digets">
                        {{ $card->getLast4() }}
                    </div>
                    <!-- /.existing-card-radio__digets -->
                </div>
                <!-- /.existing-card-radio__info -->
                <div class="existing-card-radio__expiry">
                  <span style="display: inline-block">
                    EXP.
                    <br>
                    {{ strlen($card->getExpiryMonth()) === 1 ? '0' : null }}{{ $card->getExpiryMonth() }}/{{ $card->getExpiryYear() }}
                  </span>

                  <a title="Delete card" href="/account/funds/delete/{{ $card->getReference() }}" style="display: block; float: right; padding: 10px 0 10px 10px;">
                    @icon('cross')
                  </a>
                </div>
                <!-- /.existing-card-radio__expiry -->
            </label>
        </div>
        <!-- /.existing-card-radio -->
        @endforeach
{{--
        @if ($cards->isEmpty())
          <div class="existing-card-radio">
              <input name="card" type="radio" id="new-card" value="new-card" checked>
              <label for="new-card">
                  <div class="existing-card-radio__marker"></div>
                  <div class="existing-card-radio__name">
                      New card
                  </div>
              </label>
          </div>
          <!-- /.existing-card-radio -->
        @endif --}}

        <br>

        <div class="existing-card-verification" id="existing-card-verification">
            @include('components.baseInput', [
                'name' => 'existing-cvc',
                'placeholder' => 'Field required',
                'label' => 'CVC',
                'required' => true,
                'type' => 'tel',
                'attributes' => [
                    'maxlength' => '4',
                    'data-js-restrict-input' => 'number',
                ]
            ])
        </div>


        @if ($errors->has('card'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('card') }}</strong>
            </span>
        @endif
    @endif

    @includeWhen($cards->isEmpty(), 'account.inc.newCardFormCyberSource', [
        'hidden' => count($cards) > 0
    ])

    <input id="flexresponse" name="flexresponse" type="hidden" value=""/>
    <div id="errors-output" class="form-group" role="alert">
    </div>
    <button id="pay-button" class="btn btn-primary" type="submit" {{-- disabled --}}>{{ $buttonLabel }}</button>
</form>
