<?php

namespace App\Payment\Request;

class Payout extends \Adyen\Service\Payout
{
    protected $_payout;

	public function __construct(\Adyen\Client $client)
	{
		parent::__construct($client);
		$this->_payout = new \App\Payment\Request\ResourceModel\Payout($this);
    }
    
    public function payout($params)
	{
		$result = $this->_payout->request($params);
		return $result;
	}
}
