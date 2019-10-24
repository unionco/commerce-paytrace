<?php

namespace unionco\paytrace\models;

use craft\commerce\models\PaymentSource;
use craft\commerce\models\payments\CreditCardPaymentForm;

class PayTracePaymentForm extends CreditCardPaymentForm
{
    /**
     * @var string credit card reference
     */
    public $cardReference;

    /**
     * @inheritdoc
     */
    public function populateFromPaymentSource(PaymentSource $paymentSource)
    {
        $this->cardReference = $paymentSource->token;
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        if (empty($this->cardReference)) {
            return parent::rules();
        }

        return [];
    }
}
