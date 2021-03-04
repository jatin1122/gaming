<?php

namespace App\Payment\Response;

class PaymentAuthorisedResponse extends AbstractResponse
{
    public function isSuccessful(): bool
    {
        return true;
    }

    public function isRedirect(): bool
    {
        return false;
    }

    public function getReference()
    {
        return $this->data['reference'];
    }

    public function getAuthCode()
    {
        return $this->data['authCode'];
    }
}