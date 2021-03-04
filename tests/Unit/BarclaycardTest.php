<?php

namespace Tests\Unit;

use App\Payment\Barclaycard;
use Adyen\Service\Payment;
use Adyen\Service\Payout;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BarclaycardTest extends TestCase
{
    public function setUp()
    {
        $this->client = new Barclaycard;
        $this->client->setApplicationName("Genie Gaming Unit Tests");
        $this->client->setUsername("ws@Company.GenieGaming");
        $this->client->setPassword('TB/6tf>wp76dIs1b7j%6&?u\f');
        $this->client->setEnvironment(\Adyen\Environment::TEST);
    }

    public function testPayment()
    {
        $service = new Payment($this->client);

        $result = $service->authorise([
            "card" => [
                "number" => "4111111111111111",
                "expiryMonth" => "6",
                "expiryYear" => "2016",
                "cvc" => "737",
                "holderName" => "John Smith"
            ],
            "amount" => [
                "value" => 1500,
                "currency" => "GBP"
            ],
            "reference" => "payment-test",
            "merchantAccount" => "GenieGamingEcom"
        ]);

        $this->assertEquals('Authorised', $result['resultCode']);
    }

    public function testPayout()
    {
        $service = new Payout($this->client);

        $result = $service->storeDetail(json_decode('{
            "merchantAccount": "GenieGamingEcom",
            "recurring": {
              "contract": "PAYOUT"
            },
            "amount": {
                "value": 2000,
                "currency": "GBP"
              },
            "bank": {
              "bankName": "AbnAmro",
              "bic": "ABNANL2A",
              "countryCode": "NL",
              "iban": "NL32ABNA0515071439",
              "ownerName": "Adyen",
              "bankCity": "Amsterdam",
              "taxId": "bankTaxId"
            },
            "shopperEmail": "shopper@email.com",
            "shopperReference": "yourShopperId_IOfW3k9G2PvXFu2j",
            "shopperName": {
              "firstName": "Adyen",
              "gender": "MALE",
              "lastName": "Test"
            },
            "dateOfBirth": "1990-01-01",
            "entityType": "Company",
            "nationality": "NL",
            "billingAddress": {
              "houseNumberOrName": "17",
              "street": "Teststreet 1",
              "city": "Amsterdam",
              "stateOrProvince": "NY",
              "country": "US",
              "postalCode": "12345"
            }
          }', true));

        $this->assertEquals('Success', $result['resultCode']);
    }
}
