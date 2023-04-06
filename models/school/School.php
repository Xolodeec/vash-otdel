<?php

namespace app\models\school;

class School extends \app\models\bitrix\crm\Company
{
    public $password;
    public $tokenReferral;
    public $referralLink;

    public function rules()
    {
        $rules = collect(parent::rules());
        $rules->push([['password', 'tokenReferral', 'referralLink'], 'string']);

        return $rules->toArray();
    }

    public static function mapFields()
    {
        $fields = collect(parent::mapFields());
        $fields->put('UF_CRM_1680540552402', 'password');
        $fields->put('UF_CRM_1680701873800', 'tokenReferral');
        $fields->put('UF_CRM_1680700887498', 'referralLink');

        return $fields->toArray();
    }
}
