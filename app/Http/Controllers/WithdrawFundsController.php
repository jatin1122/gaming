<?php

namespace App\Http\Controllers;

use App\Rules\MaxBalance;
use App\User;

class WithdrawFundsController extends AbstractFundsController
{
    public function index()
    {
        return view('account.fundsWithdraw', [
            'cards' => $this->barclaycard->getSavedCards()
        ]);
    }

    protected function getValidationRules(): array
    {
        return [
            'amount' => ['min:10', new MaxBalance($this->request->user())]
        ];
    }

    protected function processPayment(array $data)
    {
        return $this->barclaycard->payout($data);
    }

    protected function processFunds(User $user, float $amount)
    {
        $user->withdrawFunds($amount);

        $user->unlockFunds();

        return redirect('/account')->with('success', 'Funds withdrawn successfully');
    }
}
