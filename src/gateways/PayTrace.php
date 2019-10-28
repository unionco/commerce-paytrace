<?php

namespace unionco\paytrace\gateways;

use Craft;
use Omnipay\Common\AbstractGateway;
use craft\commerce\omnipay\base\CreditCardGateway as CraftCreditCardGateway;
use unionco\omnipay\paytrace\CreditCardGateway as Gateway;
// use Omnipay\Paytrace\

class PayTrace extends CraftCreditCardGateway
{
    /**
     * @var string $userName the PayTrace account username
     */
    public $userName = '';

    /**
     * @var string $password the PayTrace account password
     */
    public $password = '';

    /**
     * @var string $testMode run transactions in test mode
     */
    public $testMode = 'test';

    /**
     * @inheritdoc
     */
    public static function displayName(): string
    {
        return Craft::t('commerce', 'PayTrace');
    }

    /**
     * @inheritdoc
     */
    public function getSettingsHtml()
    {
        return Craft::$app->getView()->renderTemplate('commerce-paytrace/settings', ['gateway' => $this]);
    }


    // Protected Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    protected function createGateway(): AbstractGateway
    {
        /** @var Gateway $gateway */
        $gateway = static::createOmnipayGateway($this->getGatewayClassName());
        $gateway->setUserName(Craft::parseEnv($this->userName));
        $gateway->setPassword(Craft::parseEnv($this->password));
        $gateway->setTestMode(Craft::parseEnv($this->testMode));
        
        return $gateway;
    }
    // protected function createGateway(): AbstractGateway
    // {
    //     $gateway = $this->_getGateway();

    //     return $gateway;
    // }

    protected function getGatewayClassName(): string
    {
        return '\\' . Gateway::class;
    }

    // protected function getItemBagClassName(): string
    // {
    //     return '';
    // }
}
