<?php

namespace unionco\paytrace\gateways;

use Craft;
use Omnipay\Common\AbstractGateway;
use Omnipay\Paytrace\CreditCardGateway;
use unionco\paytrace\models\PayTracePaymentForm;
use craft\commerce\models\payments\BasePaymentForm;

class PayTrace extends CreditCardGateway
{
    /** @var string */
    const OMNIPAY_GATEWAY_NAME = 'Paytrace_CreditCard';

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
    public function getPaymentFormModel(): BasePaymentForm
    {
        return new PayTracePaymentForm();
    }

    /**
     * @inheritdoc
     */
    public function getSettingsHtml()
    {
        return Craft::$app->getView()->renderTemplate('commerce-paytrace/settings', ['gateway' => $this]);
    }

    /**
     * @inheritdoc
     */
    public function populateRequest(array &$request, BasePaymentForm $paymentForm = null)
    {
        parent::populateRequest($request, $paymentForm);

        if ($paymentForm && $paymentForm->hasProperty('cardReference') && $paymentForm->cardReference) {
            $request['cardReference'] = $paymentForm->cardReference;
        }
    }

    // Protected Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    protected function createGateway(): AbstractGateway
    {
        /** @var CreditCardGateway $gateway */
        $gateway = static::createOmnipayGateway(self::OMNIPAY_GATEWAY_NAME);

        $gateway->setUserName(Craft::parseEnv($this->userName));
        $gateway->setPassword(Craft::parseEnv($this->password));
        $gateway->setTestMode(Craft::parseEnv($this->testMode));


        // $gateway->setClientId(Craft::parseEnv($this->clientId));
        // $gateway->setSecret(Craft::parseEnv($this->secret));
        // $gateway->setTestMode($this->testMode);

        return $gateway;
    }

    /**
     * @inheritdoc
     */
    protected function extractPaymentSourceDescription(ResponseInterface $response): string
    {
        $data = $response->getData();
        return Craft::t('commerce-paypal', '{cardType} ending in {last4}', ['cardType' => StringHelper::upperCaseFirst($data['type']), 'last4' => $data['number']]);
    }
}
