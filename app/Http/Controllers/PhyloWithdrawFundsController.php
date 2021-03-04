<?php

namespace App\Http\Controllers;

use App\PhyloTransaction;
use App\Rules\MaxBalance;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;

class PhyloWithdrawFundsController extends Controller
{
    public function index()
    {
        return view('phylo.withdrawFunds', [
            'phylokey' => config('app.phylokey')
        ]);
    }

    public function submit(Request $request)
    {
        $user = Auth::user();
        $data = $request->validate([
            'amount' => ['required', 'number', 'min:10', new MaxBalance($this->request->user())],
            'bank_name' => 'required|string',
            'ifsc_code' => 'required|string',
            'account_holder_name' => 'required|string',
            'account_number' => 'required|string'
        ]);
        $data['phylokey'] = config('app.phylokey');
        $data['webhook_failure'] =  config('app.pfurl');
        $data['webhook_success'] =  config('app.psurl');
        $data['orderid'] = Str::random(16);

        $url = 'https://testingpayments.phylo.in/payout/requestpayout';

        $client = new Client();
        $res = $client->request('POST', $url);
        if (($res->getStatusCode() === 200)) {
            $body = $res->getBody()->getContents();
            $body = json_decode($body, true);
            $response_code = $body['response_code'];

            if ($response_code === 1) {
                $keyvalue = config('app.phylokey');
                $transactionId = $body['transaction id'];
                $verifyUrl = "https://testingpayments.phylo.in/payout/verifypayout/?txnid=$transactionId&keyvalue=$keyvalue";
                $res2 = $client->request('GET', $verifyUrl);
                $body2 = $res2->getBody()->getContents();
                $body2 = json_decode($body2, true);
                if ($body2['response_code'] === 1) {
                    $transaction = PhyloTransaction::create([
                        'user_id' => $user->id,
                        'order_id' => $data['orderid'],
                        'amount' => '-' . $data['amount'],
                        'name' => $data['name'],
                        'email' => $user->email,
                        'status' => 1,
                        'data' => json_encode($body),
                        'type' => 1
                    ]);
                    return $this->processFunds($user,  $transaction);
                }
            }
        }
    }

    protected function processFunds(User $user,  $transaction)
    {
        $user->withdrawFunds($transaction->amount);
        $user->unlockFunds();
        return redirect('/payout-success/' . $transaction->id)->with('success', 'Funds withdrawn successfully');
    }

    public function payoutFailed()
    {
        return view('phylo.payout-failed');
    }

    public function payoutSuccess(Request $request, $id)
    {
        $transaction =  PhyloTransaction::findOrFail(['id' => $id])->first();
        return view('phylo.payout-success', [
            'transaction' => $transaction
        ]);
    }
}