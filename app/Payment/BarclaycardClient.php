<?php

namespace App\Payment;

use Adyen\Client as AdyenClient;

class BarclaycardClient extends AdyenClient
{
    const LIB_VERSION = "1.5.1";
    const USER_AGENT_SUFFIX = "adyen-php-api-library/";
    const ENDPOINT_TEST = "https://pal-test.barclaycardsmartpay.com";
    const ENDPOINT_LIVE = "https://pal-live.barclaycardsmartpay.com";
    const ENDPOINT_LIVE_SUFFIX = "-pal-live.barclaycardsmartpay.com";
    const ENDPOINT_TEST_DIRECTORY_LOOKUP = "https://test.adyen.com/hpp/directory/v2.shtml";
    const ENDPOINT_LIVE_DIRECTORY_LOOKUP = "https://live.adyen.com/hpp/directory/v2.shtml";
    const API_VERSION = "v30";
    const API_RECURRING_VERSION = "v25";
    const API_CHECKOUT_VERSION = "v32";
    const API_CHECKOUT_UTILITY_VERSION = "v1";
    const ENDPOINT_TERMINAL_CLOUD_TEST = "https://pos-api-test.barclaycardsmartpay.com";
    const ENDPOINT_TERMINAL_CLOUD_LIVE = "https://pos-api-live.barclaycardsmartpay.com";
    const ENDPOINT_CHECKOUT_TEST = "https://checkout-test.barclaycardsmartpay.com/checkout";
    const ENDPOINT_CHECKOUT_LIVE_SUFFIX = "-checkout-live.barclaycardsmartpay.com/checkout";
    const ENDPOINT_PROTOCOL = "https://";

    /**
     * Set environment to connect to test or live platform of Adyen
     * For live please specify the unique identifier.
     *
     * @param $environment test
     * @param null $liveEndpointUrlPrefix Provide the unique live url prefix from the "API URLs and Response" menu in the Adyen Customer Area
     * @throws AdyenException
     */
    public function setEnvironment($environment, $liveEndpointUrlPrefix = null)
    {
        if ($environment == \Adyen\Environment::TEST) {
            $this->getConfig()->set('environment', \Adyen\Environment::TEST);
            $this->getConfig()->set('endpoint', self::ENDPOINT_TEST);
            $this->getConfig()->set('endpointDirectorylookup', self::ENDPOINT_TEST_DIRECTORY_LOOKUP);
            $this->getConfig()->set('endpointTerminalCloud', self::ENDPOINT_TERMINAL_CLOUD_TEST);
            $this->getConfig()->set('endpointCheckout', self::ENDPOINT_CHECKOUT_TEST);
        } elseif ($environment == \Adyen\Environment::LIVE) {
            $this->getConfig()->set('environment', \Adyen\Environment::LIVE);
            $this->getConfig()->set('endpointDirectorylookup', self::ENDPOINT_LIVE_DIRECTORY_LOOKUP);
            $this->getConfig()->set('endpointTerminalCloud', self::ENDPOINT_TERMINAL_CLOUD_LIVE);

            if ($liveEndpointUrlPrefix) {
                $this->getConfig()->set('endpoint', self::ENDPOINT_PROTOCOL . $liveEndpointUrlPrefix . self::ENDPOINT_LIVE_SUFFIX);
                $this->getConfig()->set('endpointCheckout', self::ENDPOINT_PROTOCOL . $liveEndpointUrlPrefix . self::ENDPOINT_CHECKOUT_LIVE_SUFFIX);
            } else {
                $this->getConfig()->set('endpoint', self::ENDPOINT_LIVE);
                $this->getConfig()->set('endpointCheckout', null); // not supported please specify unique identifier
            }
        } else {
            // environment does not exist
            $msg = "This environment does not exist, use " . \Adyen\Environment::TEST . ' or ' . \Adyen\Environment::LIVE;
            throw new \Adyen\AdyenException($msg);
        }
    }
}