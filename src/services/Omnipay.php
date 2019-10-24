<?php

namespace unionco\paytrace\services;

use craft\base\Component;

class Omnipay extends Component
{
    public $gateway;

    /** @var string */
    const OMNIPAY_GATEWAY_NAME = 'Paytrace_CreditCard';


    public function getGateway($userName, $password, $testMode)
    {
        /** @var CreditCardGateway $gateway */
        $gateway = static::createOmnipayGateway(self::OMNIPAY_GATEWAY_NAME);

        $gateway->setUserName(Craft::parseEnv($userName));
        $gateway->setPassword(Craft::parseEnv($password));
        $gateway->setTestMode(Craft::parseEnv($testMode));

        $this->gateway = $gateway;

        return $gateway;
    }
}