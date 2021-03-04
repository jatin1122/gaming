<?php

namespace App\Http\Controllers;

use App\CyberSource\Resource\ExternalConfiguration;
use App\CyberSource\Response\PaymentAuthorisedResponse;
use App\Rules\CanNotExceedBalance;
use App\User;
use Cybersource\ApiException;
use Illuminate\Support\Str;

class CyberSourceDepositFundsController extends CyberSourceAbstractFundsController
{
    protected function getValidationRules(): array
    {
        return [
            'amount' => ['min:5', new CanNotExceedBalance($this->request->user())]
        ];
    }

    public function index()
    {
        $commonElement = new ExternalConfiguration();
        $config = $commonElement->ConnectionHost();
        $merchantConfig = $commonElement->merchantConfigObject();
        $apiclient = new \CyberSource\ApiClient($config, $merchantConfig);
        $api_instance = new \CyberSource\Api\KeyGenerationApi($apiclient);
        $flexRequestArr = [
            "encryptionType" => "RsaOaep256",
            "targetOrigin" => config('app.url'),
        ];

        $keyResponse = null;
        try {
            $keyResponse = $api_instance->generatePublicKey('JWT', $flexRequestArr);
            $captureContext = $keyResponse[0]["keyId"];;
            return view('account.fundsDepositCyberSource', [
                'cards' => collect([]),
                'captureContext' => $captureContext
            ]);
        } catch (ApiException $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    protected function processPayment()
    {
        $flexresponse = $this->request->get('flexresponse');
        $amount = $this->request->get('amount');
        $apiResponse = '';
        $transientTokenJWK = $flexresponse;

        $userData  = $this->request->user();
        $randomStr = Str::random(30);
        $clientReferenceInformationArr = [
            "code" => 'GG_' . $randomStr
        ];
        $clientReferenceInformation = new \CyberSource\Model\Ptsv2paymentsClientReferenceInformation($clientReferenceInformationArr);

        $orderInformationAmountDetailsArr = [
            "totalAmount" => $amount,
            "currency" => "GBP"
        ];
        $orderInformationAmountDetails = new \CyberSource\Model\Ptsv2paymentsOrderInformationAmountDetails($orderInformationAmountDetailsArr);

        $orderInformationBillToArr = [
            "firstName" => $userData->first_name,
            "lastName" => $userData->last_name,
            "country" => $userData->country,
            "email" => $userData->email,
            "phoneNumber" => $userData->phone,
            'address1' => 'NA',
            'locality' => 'NA'
        ];
        $orderInformationBillTo = new \CyberSource\Model\Ptsv2paymentsOrderInformationBillTo($orderInformationBillToArr);

        $orderInformationArr = [
            "amountDetails" => $orderInformationAmountDetails,
            "billTo" => $orderInformationBillTo
        ];
        $orderInformation = new \CyberSource\Model\Ptsv2paymentsOrderInformation($orderInformationArr);

        $processingInformationArr = [
            "capture" => true
        ];
        $processingInformation = new \CyberSource\Model\Ptsv2paymentsProcessingInformation($processingInformationArr);


        $tokenInformationArr = [
            "transientTokenJwt" => $transientTokenJWK
        ];
        $tokenInformation = new \CyberSource\Model\Ptsv2paymentsTokenInformation($tokenInformationArr);

        $requestObjArr = [
            "clientReferenceInformation" => $clientReferenceInformation,
            "orderInformation" => $orderInformation,
            "tokenInformation" => $tokenInformation,
            "processingInformation" => $processingInformation
        ];
        $requestObj = new \CyberSource\Model\CreatePaymentRequest($requestObjArr);
        $commonElement = new ExternalConfiguration();
        $config = $commonElement->ConnectionHost();
        $merchantConfig = $commonElement->merchantConfigObject();

        $api_client = new \CyberSource\ApiClient($config, $merchantConfig);
        $api_instance = new \CyberSource\Api\PaymentsApi($api_client);
        $apiResponse = $api_instance->createPayment($requestObj);
        return new PaymentAuthorisedResponse($apiResponse);
    }

    protected function processFunds(User $user, float $amount)
    {
        $user->depositFunds($amount);

        $user->unlockFunds();

        return redirect('/account')->with('success', 'Funds deposited successfully');
    }
}
