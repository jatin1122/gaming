<?php

namespace App\Payment\Resource;

use App\Payment\Common\ArrayAccessableResource;

class Card extends ArrayAccessableResource
{
    public function getReference()
    {
        return $this['recurringDetailReference'];
    }

    public function getBrand(): string
    {
        return $this['variant'];
    }

    public function getExpiryMonth()
    {
        return $this['card']['expiryMonth'];
    }
    
    public function getExpiryYear()
    {
        return $this['card']['expiryYear'];
    }

    public function getCardholderName()
    {
        return $this['card']['holderName'];
    }

    public function getLast4()
    {
        return $this['card']['number'];
    }
    public function getName()
    {
        return $this['card']['holderName'];
    }
}