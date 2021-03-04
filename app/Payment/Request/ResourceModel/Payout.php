<?php

namespace App\Payment\Request\ResourceModel;

class Payout extends \Adyen\Service\AbstractResource
{
	/**
	 * @var string
	 */
	protected $_endpoint;

	/**
	 * Confirm constructor.
	 *
	 * @param \Adyen\Service $service
	 */
	public function __construct($service)
	{
		$this->_endpoint = $service->getClient()->getConfig()->get('endpoint') . '/pal/servlet/Payout/' . $service->getClient()->getApiPayoutVersion() . '/payout';
		parent::__construct($service, $this->_endpoint);
	}
}
