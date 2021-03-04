<?php

namespace App\Payment;

use App\User;
use Adyen\Service\Payment;
use App\Payment\Exception\PaymentRefusedException;
use App\Payment\Exception\PaymentErrorException;
use App\Payment\Exception\PaymentCancelledException;
use App\Payment\Exception\PaymentException;
use App\Payment\Response\PaymentAuthorisedResponse;
use Adyen\Service\Recurring;
use App\Payment\Request\Payout;
use Illuminate\Support\Collection;
use App\Payment\Resource\Card;
use Illuminate\Http\Request;

class Barclaycard
{
    protected $client;

    public function __construct(BarclaycardClient $paymentClient, BarclaycardClient $storePayoutClient, BarclaycardClient $reviewPayoutClient, Request $request)
    {
        $this->paymentClient = $paymentClient;
        $this->storePayoutClient = $storePayoutClient;
        $this->reviewPayoutClient = $reviewPayoutClient;
        $this->request = $request;
    }

    public function authorise(array $data)
    {
        $payment = new Payment($this->paymentClient);

        $response = $payment->authorise(array_merge_recursive($data, [
            'amount' => [
                'currency' => 'GBP',
            ],
            'reference' => 'Genie Gaming Deposit',
            'shopperEmail' => $this->request->user()->email,
            'shopperIP' => $this->request->ip(),
            'shopperReference' => $this->request->user()->id,
        ]));

        switch ($response['resultCode']) {
            case 'Authorised':
                return new PaymentAuthorisedResponse($response);
                break;

                // case 'Received':
                //     return 'something?';

                // case 'RedirectShopper':
                //     return 'something?';

            case 'Refused':
                throw new PaymentRefusedException("Payment refused: {$response['refusalReason']}");

            case 'Error':
                throw new PaymentErrorException("Payment refused: {$response['refusalReason']}");

            case 'Cancelled':
                throw new PaymentCancelledException("Payment refused: {$response['refusalReason']}");

            default:
                throw new PaymentException("Invalid response code: {$response['resultCode']}");
        }
    }

    public function payout(array $data)
    {
        $payout = new Payout($this->storePayoutClient);

        $response = $payout->submit(array_merge_recursive($data, [
            'amount' => [
                'currency' => 'GBP',
            ],
            'reference' => 'Genie Gaming Payout',
            'shopperEmail' => $this->request->user()->email,
            'shopperIP' => $this->request->ip(),
            'shopperReference' => $this->request->user()->id,
        ]));

        if ($response['resultCode'] != '[payout-submit-received]') {
            throw new PaymentException('Unable to process payout');
        }

        $payout = new Payout($this->reviewPayoutClient);

        $response = $payout->confirm([
            'merchantAccount' => 'GenieGamingEcom',
            'originalReference' => $response['pspReference']
        ]);

        switch ($response['response']) {
            case '[payout-confirm-received]':
                return new PaymentAuthorisedResponse($response);
                break;

            default:
                throw new PaymentException("Invalid response code: {$response['response']}");
        }
    }

    public function getSavedCards(): Collection
    {
        $recurring = new Recurring($this->paymentClient);

        $response = $recurring->listRecurringDetails([
            'shopperReference' => $this->request->user()->id
        ]);

        $collection = new Collection;

        // If there aren't any saved cards, just return an empty collection
        if (empty($response) or !isset($response['details'])) {
            return $collection;
        }

        foreach ($response['details'] ?? [] as $card) {
            $collection->push(new Card($card['RecurringDetail']));
        }

        return $collection;
    }

    public function deleteCard($cardRef)
    {
        $recurring = new Recurring($this->paymentClient);

        $response = $recurring->disable([
            'shopperReference' => $this->request->user()->id,
            'recurringDetailReference' => $cardRef
        ]);

        return true;
    }
}
