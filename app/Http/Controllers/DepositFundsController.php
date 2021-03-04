<?php

namespace App\Http\Controllers;

use App\Rules\CanNotExceedBalance;
use App\User;

class DepositFundsController extends AbstractFundsController
{
    protected function getValidationRules(): array
    {
        return [
            'amount' => ['min:5', new CanNotExceedBalance($this->request->user())]
        ];
    }

    public function index()
    {
        $cards = "";
        return view('account.fundsDeposit', [
            'cards' => []
        ]);
    }

    public function submitPayment(){
        echo "<pre>";
        print_r($this->request->all());
        print_r($this->request->get('flexresponse'));
        die("hello");
    }
    protected function processPayment(array $data)
    {
        return $this->barclaycard->authorise($data);
    }

    protected function processFunds(User $user, float $amount)
    {
        $user->depositFunds($this->request->get('amount'));

        $user->unlockFunds();

        return redirect('/account')->with('success', 'Funds deposited successfully');
    }
}
