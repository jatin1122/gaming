<?php

namespace App\Http\Controllers;

use App\PhyloTransaction;
use App\Rules\CanNotExceedBalance;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use GuzzleHttp\Client;

class PhyloDepositFundsController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        $random =  Str::random(16);
        $orderID = $user->id . '_' . $random;
        return view('phylo.fundsDeposit', [
            'phylokey' => config('app.phylokey'),
            'surl' => config('app.surl'),
            'furl' => config('app.furl'),
            'orderID' => $orderID
        ]);
    }

    public function submit(Request $request)
    {
        if ($request->get('status') === 'success') {
            $transactionId = $request->get('txnid');
            $paymentVerifyUrl = "https://testingpayments.phylo.in/Pay/verify_transaction/?txnid=$transactionId&keyvalue=" . config('app.phylokey');
            $client = new Client();
            $res = $client->request('GET', $paymentVerifyUrl);
            if (($res->getStatusCode() === 200)) {
                $body = $res->getBody()->getContents();
                $body = json_decode($body, true);
                $payment = $body['payment'];
                $orderID = $payment['orderid'];
                $userID = explode('_', $orderID)[0];
                $user = User::where(['id' => $userID])->first();
                if (!$user) {
                    return redirect('/');
                }
                $transaction = PhyloTransaction::create([
                    'user_id' => $userID,
                    'order_id' => $orderID,
                    'amount' => $payment['amount'],
                    'name' => $payment['name'],
                    'email' => $payment['email'],
                    'status' => 1,
                    'data' => json_encode($body)
                ]);
                return $this->processFunds($user,  $transaction);
            }
        }
        return redirect('/phylo/payment-failed');
    }

    public function paymentFailed()
    {
        return view('phylo.payment-failed');
    }



    public function paymentSuccess($id, Request $request)
    {
        $transaction =  PhyloTransaction::findOrFail(['id' => $id])->first();
        return view('phylo.payment-success', [
            'transaction' => $transaction
        ]);
    }

    protected function processFunds(User $user,  $transaction)
    {
        $user->depositFunds($transaction->amount);
        $user->unlockFunds();
        return redirect('/payment-success/' . $transaction->id)->with('success', 'Funds deposited successfully');
    }
}