<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;

class BannedController extends Controller
{
    public function __construct()
    {
        $this->middleware('banned.only');
    }

    public function display(Request $request)
    {
        return view('auth.banned', [
            'user' => $request->user()
        ]);
    }
}