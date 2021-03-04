<?php

namespace App\CyberSource\Resource;

use CyberSource\Configuration as BaseConfiguration;

class Configuration extends BaseConfiguration
{
    //initialize variable on constructor
    function __construct()
    {
        $this->authType = config('cybersource.authType'); //http_signature/jwt
        $this->enableLog = config('cybersource.enableLog');
        $this->logSize = config('cybersource.logSize');
        $this->logFile = config('cybersource.logFile');
        $this->logFilename = config('cybersource.logFilename');
        $this->merchantID = config('cybersource.merchantID');
        $this->apiKeyID = config('cybersource.apiKeyID');
        $this->secretKey = config('cybersource.secretKey');
        $this->runEnv = config('cybersource.runEnv') === 'sandbox' ? "cyberSource.environment.SANDBOX" : "cyberSource.environment.PRODUCTION";
        $this->merchantConfigObject();
    }
    //creating merchant config object
    function merchantConfigObject()
    {
        $config = new \CyberSource\Authentication\Core\MerchantConfiguration();
        if (is_bool($this->enableLog))
            $confiData = $config->setDebug($this->enableLog);

        $confiData = $config->setLogSize(trim($this->logSize));
        $confiData = $config->setDebugFile(trim($this->logFile));
        $confiData = $config->setLogFileName(trim($this->logFilename));
        $confiData = $config->setAuthenticationType(strtoupper(trim($this->authType)));
        $confiData = $config->setMerchantID(trim($this->merchantID));
        $confiData = $config->setApiKeyID($this->apiKeyID);
        $confiData = $config->setSecretKey($this->secretKey);
        //$confiData = $config->setCurlProxyHost($this->proxyUrl);
        //$confiData = $config->setCurlProxyPort($this->proxyHost);
        // $confiData = $config->setKeyFileName(trim($this->keyFilename));
        // $confiData = $config->setKeyAlias($this->keyAlias);
        // $confiData = $config->setKeyPassword($this->keyPass);
        // $confiData = $config->setKeysDirectory($this->keyDirectory);
        $confiData = $config->setRunEnvironment($this->runEnv);
        $config->validateMerchantData($confiData);
        return $config;
    }
}
