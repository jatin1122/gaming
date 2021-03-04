<?php

namespace App\Http\Controllers;

use App\CyberSource\Resource\ExternalConfiguration;
use App\CyberSource\Response\PaymentAuthorisedResponse;

use App\Rules\MaxBalance;
use App\User;
use Cybersource\ApiException;
use Illuminate\Support\Str;

class CyberSourceWithdrawFundsController extends CyberSourceAbstractFundsController
{
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
            return view('account.fundsWithdrawCyberSource', [
                'cards' => collect([]),
                'captureContext' => $captureContext
            ]);
        } catch (ApiException $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    protected function getValidationRules(): array
    {
        return [
            'amount' => ['min:10', new MaxBalance($this->request->user())]
        ];
    }

    protected function processPayment()
    {
        $flexresponse = $this->request->get('flexresponse');
        $amount = $this->request->get('amount');
        $randomStr = Str::random(30);
        $clientReferenceInformationArr = [
            "code" => 'GG_' . $randomStr
        ];
        $clientReferenceInformation = new \CyberSource\Model\Ptsv2payoutsClientReferenceInformation($clientReferenceInformationArr);

        $orderInformationAmountDetailsArr = [
            "totalAmount" =>  $amount,
            "currency" => "GBP"
        ];
        $orderInformationAmountDetails = new \CyberSource\Model\Ptsv2payoutsOrderInformationAmountDetails($orderInformationAmountDetailsArr);

        $orderInformationArr = [
            "amountDetails" => $orderInformationAmountDetails
        ];
        $orderInformation = new \CyberSource\Model\Ptsv2payoutsOrderInformation($orderInformationArr);

        $merchantInformationMerchantDescriptorArr = [
            "name" => "Sending Company Name",
            "locality" => "FC",
            "country" => "US",
            "administrativeArea" => "CA",
            "postalCode" => "94440"
        ];
        $merchantInformationMerchantDescriptor = new \CyberSource\Model\Ptsv2payoutsMerchantInformationMerchantDescriptor($merchantInformationMerchantDescriptorArr);

        $merchantInformationArr = [
            "merchantDescriptor" => $merchantInformationMerchantDescriptor
        ];
        $merchantInformation = new \CyberSource\Model\Ptsv2payoutsMerchantInformation($merchantInformationArr);

        $recipientInformationArr = [
            "firstName" => "John",
            "lastName" => "Doe",
            "address1" => "Paseo Padre Boulevard",
            "locality" => "Foster City",
            "administrativeArea" => "CA",
            "country" => "US",
            "postalCode" => "94400",
            "phoneNumber" => "6504320556"
        ];
        $recipientInformation = new \CyberSource\Model\Ptsv2payoutsRecipientInformation($recipientInformationArr);

        $senderInformationAccountArr = [
            "fundsSource" => "01"
        ];
        $senderInformationAccount = new \CyberSource\Model\Ptsv2payoutsSenderInformationAccount($senderInformationAccountArr);

        $senderInformationArr = [
            "referenceNumber" => "1234567890",
            "account" => $senderInformationAccount,
            "name" => "Company Name",
            "address1" => "900 Metro Center Blvd.900",
            "locality" => "Foster City",
            "administrativeArea" => "CA",
            "countryCode" => "US"
        ];
        $senderInformation = new \CyberSource\Model\Ptsv2payoutsSenderInformation($senderInformationArr);

        $processingInformationArr = [
            "commerceIndicator" => "internet",
            "businessApplicationId" => "FD"
        ];
        $processingInformation = new \CyberSource\Model\Ptsv2payoutsProcessingInformation($processingInformationArr);

        $tokenInformationArr = [
            "transientTokenJwt" => $flexresponse
        ];
        $tokenInformation = new \CyberSource\Model\Ptsv2paymentsTokenInformation($tokenInformationArr);

        $requestObjArr = [
            "clientReferenceInformation" => $clientReferenceInformation,
            "orderInformation" => $orderInformation,
            "merchantInformation" => $merchantInformation,
            "recipientInformation" => $recipientInformation,
            "senderInformation" => $senderInformation,
            "processingInformation" => $processingInformation,
            "tokenInformation" => $tokenInformation
        ];

        $requestObj = new \CyberSource\Model\CreatePaymentRequest($requestObjArr);

        $commonElement = new ExternalConfiguration();
        $config = $commonElement->ConnectionHost();
        $merchantConfig = $commonElement->merchantConfigObject();

        $api_client = new \CyberSource\ApiClient($config, $merchantConfig);
        $api_instance = new \CyberSource\Api\PayoutsApi($api_client);

        try {
            $apiResponse = $api_instance->octCreatePayment($requestObj);
            print_r(PHP_EOL);
            print_r($apiResponse);
            die;

            return $apiResponse;
        } catch (\Cybersource\ApiException $e) {
            print_r($requestObj);
            print_r($e->getResponseBody());
            print_r($e->getMessage());
            die;
        }
    }

    protected function processFunds(User $user, float $amount)
    {
        $user->withdrawFunds($amount);

        $user->unlockFunds();

        return redirect('/account')->with('success', 'Funds withdrawn successfully');
    }
}
