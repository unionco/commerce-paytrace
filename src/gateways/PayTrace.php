<?php

namespace unionco\paytrace\gateways;

use Craft;
use craft\commerce\base\Gateway;
use craft\base\ComponentInterface;
use craft\commerce\elements\Order;
use Omnipay\Common\AbstractGateway;
use craft\commerce\models\Transaction;
use Omnipay\Paytrace\CreditCardGateway;
use craft\commerce\models\PaymentSource;
use craft\commerce\base\GatewayInterface;
use craft\commerce\omnipay\base\RequestResponse;
use unionco\paytrace\models\PayTracePaymentForm;
use craft\commerce\base\RequestResponseInterface;
use unionco\paytrace\PayTrace as UnioncoPayTrace;
use craft\commerce\models\payments\BasePaymentForm;
use craft\commerce\omnipay\base\CreditCardGateway as CraftCreditCardGateway;

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
    public function getPaymentFormHtml(array $params)
    {
        return Craft::$app->getView()->renderTemplate('commerce-paytrace/paymentForm');
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
        $gateway = $this->_getGateway();

        return $gateway;
    }

    public function getGatewayClassName(): string
    {
        return '';
    }

    // public static function isSelectable(): bool
    // {
    //     return true;
    // }

    // /**
    //  * @inheritdoc
    //  */
    // protected function extractPaymentSourceDescription(ResponseInterface $response): string
    // {
    //     $data = $response->getData();
    //     return Craft::t('commerce-paypal', '{cardType} ending in {last4}', ['cardType' => StringHelper::upperCaseFirst($data['type']), 'last4' => $data['number']]);
    // }

    // public function authorize(array $params = [])
    // {
    //     $requestResponse = 
    // }

    // Methods from GatewayInterface
        /**
     * Makes an authorize request.
     *
     * @param Transaction $transaction The authorize transaction
     * @param BasePaymentForm $form A form filled with payment info
     * @return RequestResponseInterface
     */
    // public function authorize(Transaction $transaction, BasePaymentForm $form): RequestResponseInterface
    // {
    //     $gateway = $this->_getGateway();
    //     // return $gateway->authorize()
    // }

    /**
     * Makes a capture request.
     *
     * @param Transaction $transaction The capture transaction
     * @param string $reference Reference for the transaction being captured.
     * @return RequestResponseInterface
     */
    // public function capture(Transaction $transaction, string $reference): RequestResponseInterface;

    /**
     * Complete the authorization for offsite payments.
     *
     * @param Transaction $transaction The transaction
     * @return RequestResponseInterface
     */
    // public function completeAuthorize(Transaction $transaction): RequestResponseInterface;

    /**
     * Complete the purchase for offsite payments.
     *
     * @param Transaction $transaction The transaction
     * @return RequestResponseInterface
     */
    // public function completePurchase(Transaction $transaction): RequestResponseInterface;

    /**
     * Creates a payment source from source data and user id.
     *
     * @param BasePaymentForm $sourceData
     * @param int $userId
     * @return PaymentSource
     */
    // public function createPaymentSource(BasePaymentForm $sourceData, int $userId): PaymentSource;

    /**
     * Deletes a payment source on the gateway by its token.
     *
     * @param string $token
     * @return bool
     */
    // public function deletePaymentSource($token): bool;

    // /**
    //  * Returns payment form model to use in payment forms.
    //  *
    //  * @return BasePaymentForm
    //  */
    // public function getPaymentFormModel(): BasePaymentForm;

    /**
     * Makes a purchase request.
     *
     * @param Transaction $transaction The purchase transaction
     * @param BasePaymentForm $form A form filled with payment info
     * @return RequestResponseInterface
     */
    public function purchase(Transaction $transaction, BasePaymentForm $form): RequestResponseInterface
    // public function purchase(array $params = [])
    {
        
        $gateway = $this->_getGateway();
        return $gateway->purchase([]);
    }

    /**
     * Makes an refund request.
     *
     * @param Transaction $transaction The refund transaction
     * @return RequestResponseInterface
     */
    // public function refund(Transaction $transaction): RequestResponseInterface;

    /**
     * Processes a webhook and return a response
     *
     * @return WebResponse
     * @throws Throwable if something goes wrong
     */
    // public function processWebHook(): WebResponse
    // {

    // }

    /**
     * Returns true if gateway supports authorize requests.
     *
     * @return bool
     */
    public function supportsAuthorize(): bool
    {
        return false;
    }

    /**
     * Returns true if gateway supports capture requests.
     *
     * @return bool
     */
    public function supportsCapture(): bool
    {
        return false;
    }

    /**
     * Returns true if gateway supports completing authorize requests
     *
     * @return bool
     */
    public function supportsCompleteAuthorize(): bool
    {
        return false;
    }

    /**
     * Returns true if gateway supports completing purchase requests
     *
     * @return bool
     */
    public function supportsCompletePurchase(): bool
    {
        return true;
    }

    /**
     * Returns true if gateway supports payment sources
     *
     * @return bool
     */
    public function supportsPaymentSources(): bool
    {
        return false;
    }

    /**
     * Returns true if gateway supports purchase requests.
     *
     * @return bool
     */
    public function supportsPurchase(): bool
    {
        return true;
    }

    /**
     * Returns true if gateway supports refund requests.
     *
     * @return bool
     */
    public function supportsRefund(): bool
    {
        return false;
    }

    /**
     * Returns true if gateway supports partial refund requests.
     *
     * @return bool
     */
    public function supportsPartialRefund(): bool
    {
        return false;
    }

    /**
     * Returns true if gateway supports webhooks.
     *
     * @return bool
     */
    public function supportsWebhooks(): bool
    {
        return false;
    }

    /**
     * Returns true if gateway supports payments for the supplied Order.
     *
     * @param $order Order The order this gateway can or can not be available for payment with.
     * @return bool
     */
    public function availableForUseWithOrder(Order $order): bool
    {
        return true;
    }

    public static function isSelectable(): bool
    {
        return true;
    }

    /**
     * @return CreditCardGateway
     */
    private function _getGateway()
    {
        $gateway = UnioncoPayTrace::$plugin->omnipay->getGateway(
            Craft::parseEnv($this->userName),
            Craft::parseEnv($this->password),
            Craft::parseEnv($this->testMode)
        );
        return $gateway;
    }
}
