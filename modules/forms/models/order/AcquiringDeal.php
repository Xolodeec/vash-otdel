<?php

namespace app\modules\forms\models\order;

use app\models\bitrix\crm\Deal;

class AcquiringDeal extends Deal
{
    public $invoiceUrl;
    public $invoiceId;

    public function rules()
    {
        $rules = collect(parent::rules());
        $rules->push([['invoiceUrl', 'invoiceId'], 'string']);

        return $rules->toArray();
    }

    public static function mapFields()
    {
        $mapFields = collect(parent::mapFields());
        $mapFields->put('UF_CRM_1682345797144', 'invoiceId');
        $mapFields->put('UF_CRM_1682348050', 'invoiceUrl');

        return $mapFields->toArray();
    }

}
