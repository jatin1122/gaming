<?php

namespace App\Http\Controllers;

use App\CyberSource\Resource\ExternalConfiguration;
use Illuminate\Http\Request;
use App\Payment\Barclaycard;

use App\User;
use Exception;

abstract class CyberSourceAbstractFundsController extends Controller
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

    abstract protected function processPayment();

    abstract protected function processFunds(User $user, float $amount);

    private function allValidationRules()
    {
        return array_merge_recursive([
            'amount' => ['required', 'numeric'],
            'flexresponse' => ['required'],

        ], $this->getValidationRules());
    }

    public function submit()
    {
        $this->request->validate($this->allValidationRules());
        try {

            $payment = $this->processPayment();
            if ($payment->isSuccessful()) {
                $this->request->user()->lockFunds();
                return $this->processFunds($this->request->user(), $this->request->get('amount'));
            }
        } catch (Exception  $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
