<?php

namespace app\models\school;

class School extends \app\models\bitrix\crm\Company
{
    public $password;
    public $tokenReferral;
    public $referralLinkInstallment;
    public $referralLinkAcquiring;
    public $telegramId;
    public $email;

    public function rules()
    {
        $rules = collect(parent::rules());
        $rules->push([['password', 'tokenReferral', 'referralLinkInstallment', 'referralLinkAcquiring', 'telegramId'], 'string']);

        return $rules->toArray();
    }

    public static function mapFields()
    {
        $fields = collect(parent::mapFields());
        $fields->put('UF_CRM_1680540552402', 'password');
        $fields->put('UF_CRM_1680701873800', 'tokenReferral');
        $fields->put('UF_CRM_1680700887498', 'referralLinkInstallment');
        $fields->put('UF_CRM_1682348859306', 'referralLinkAcquiring');
        $fields->put('UF_CRM_1683203303333', 'telegramId');
        $fields->put('EMAIL', 'email');

        return $fields->toArray();
    }
}
