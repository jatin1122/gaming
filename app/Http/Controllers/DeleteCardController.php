<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Payment\Barclaycard;
use App\Payment\Exception\PaymentException;

class DeleteCardController extends Controller
{
    public function __construct(Request $request, Barclaycard $barclaycard)
    {
        $this->middleware('auth');

        $this->barclaycard = $barclaycard;
        $this->request = $request;
    }

    public function index()
    {
        return view('account.cardDelete', [
            // 'cards' => $this->barclaycard->getSavedCards()
        ]);
    }


    public function confirm($cardRef)
    {
        if ($this->request->get('encrypted_data') == 'false') {
            return redirect()->back()->with('error', 'Unable to process funds. Please fill in all of the required fields and try again');
        } else {
            try {
                if ($this->request->user()->getBalance() > 0) {
                    $this->barclaycard->payout([
                        'additionalData' => [
                            'card.encrypted.json' => $this->request->get('encrypted_data')
                        ],
                        'selectedRecurringDetailReference' => $cardRef,
                        'amount' => [
                            'value' => $this->request->user()->getBalance() * 100,
                        ],
                        'recurring' => [
                            'contract' => 'PAYOUT,RECURRING,ONECLICK'
                        ]
                    ]);

                    $this->request->user()->withdrawFunds(
                        $this->request->user()->getBalance()
                    );
                }
                
                $this->barclaycard->deleteCard($cardRef);

                return redirect('/account/funds')->with('success', 'Card deleted successfully');
            } catch (PaymentException $e) {
                return redirect('/account/funds')->with('error', 'Unable to delete card: '.$e->getMessage());
            }
      }
    }
}
