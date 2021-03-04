<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaction;
use App\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AccountHistoryController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transactions = [];

        for ($monthsAgo=0; $monthsAgo < 12; $monthsAgo++) {
            $monthTransactions = Auth::user()->transactions()
                ->whereMonth('created_at', Carbon::now()->startOfMonth()->subMonth($monthsAgo)->format('m'))
                ->get();

            $transactions[$monthsAgo] = $monthTransactions;
        }


        $data = [
            'transactions' => $transactions
        ];

        return view('account.history', $data);
    }

}
