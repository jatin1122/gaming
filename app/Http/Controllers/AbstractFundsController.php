<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Payment\Barclaycard;
use App\Payment\Exception\PaymentException;
use Adyen\AdyenException;
use App\User;

abstract class AbstractFundsController extends Controller
{
    protected $validationRules = [];

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request, Barclaycard $barclaycard)
    {
        $this->middleware('auth');

        $this->barclaycard = $barclaycard;
        $this->request = $request;
    }

    abstract public function index();

    abstract protected function getValidationRules(): array;

    abstract protected function processPayment(array $data);

    abstract protected function processFunds(User $user, float $amount);

    private function allValidationRules()
    {
        return array_merge_recursive([
            'amount' => ['required', 'numeric'],
            'card' => ['nullable', function ($value) {
                return $this->barclaycard->getSavedCards()->contains(function ($card) use ($value) {
                    return $card->getReference() == $value;
                });
            }]
        ], $this->getValidationRules());
    }

    public function submit()
    {
        if ($this->request->get('encrypted_data') == 'false') {
            return redirect()->back()->with('error', 'Unable to process funds. Please fill in all of the required fields and try again');
        }

        $this->request->validate($this->allValidationRules());

        try {
            $cardReference = $this->request->get('card');
            if ($cardReference && $cardReference != 'new-card') {

                $savedCards = $this->barclaycard->getSavedCards();

                $savedCard = $savedCards->contains(function ($savedCard) use ($cardReference) {
                    return $savedCard->getReference() == $cardReference;
                });

                if (!$savedCard) {
                    throw new \InvalidArgumentException('Invalid card');
                }

                if ($this->request->user()->hasLockedFunds()) {
                    return back()->with('error', 'Payment failed. Try again in 1 minute.');
                }

                $this->request->user()->lockFunds();

                $payment = $this->processPayment([
                    'additionalData' => [
                        'card.encrypted.json' => $this->request->get('encrypted_data')
                    ],
                    'selectedRecurringDetailReference' => $savedCards->first(function ($card) use ($cardReference) {
                        return $card->getReference() == $cardReference;
                    })->getReference(),
                    'amount' => [
                        'value' => $this->request->get('amount') * 100,
                    ],
                    'recurring' => [
                        'contract' => 'RECURRING,ONECLICK,PAYOUT'
                    ]
                ]);
            } else {
                $payment = $this->processPayment([
                    'additionalData' => [
                        'card.encrypted.json' => $this->request->get('encrypted_data')
                    ],
                    'amount' => [
                        'value' => $this->request->get('amount') * 100,
                    ],
                    'recurring' => [
                        'contract' => 'RECURRING,ONECLICK,PAYOUT'
                    ]
                ]);
            }


            if ($payment->isSuccessful()) {
                return $this->processFunds($this->request->user(), $this->request->get('amount'));
            }
        } catch (PaymentException | AdyenException $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
