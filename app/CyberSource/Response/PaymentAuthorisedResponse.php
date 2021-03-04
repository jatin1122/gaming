<?php

namespace App\CyberSource\Response;

class PaymentAuthorisedResponse extends AbstractResponse
{
    public function isSuccessful(): bool
    {
        return $this->data[0]['status'] === 'AUTHORIZED';
    }

    public function getId()
    {
        return $this->data[0]['id'];
    }
}
