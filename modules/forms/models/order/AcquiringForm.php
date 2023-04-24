<?php

namespace app\modules\forms\models\order;

use app\models\PayKeeper;

class AcquiringForm extends OrderForm
{
    protected $paymentData;

    public function createPaymentLink()
    {
        $payKeeper = new PayKeeper(\Yii::$app->params['payKeeper']['host'], \Yii::$app->params['payKeeper']['login'], \Yii::$app->params['payKeeper']['password']);

        $this->paymentData = $payKeeper->getPaymentData([
            'pay_amount' => $this->getSelectedProduct()->price,
            'service_name' => $this->getSelectedProduct()->name,
            'client_phone' => $this->phone,
            'clientid' => "{$this->lastName} {$this->name} {$this->secondName}",
        ]);

        return $this->paymentData['invoice_url'];
    }

    public function collectDeal()
    {
        $deal = new AcquiringDeal();
        $deal->companyId = $this->company->id;
        $deal->invoiceId = $this->paymentData['invoice_id'];
        $deal->invoiceUrl = $this->paymentData['invoice_url'];
        $deal->categoryId = 1;
        $deal->validate();

        return $deal;
    }

}
