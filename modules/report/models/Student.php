<?php

namespace app\modules\report\models;

use app\models\bitrix\crm\Contact;
use yii\base\Model;

class Student extends Contact
{
    public $countLoseDeal;
    public $countApologyDeal;
    public $countWonDeal;
    public $assignedByCompany;
    public $wonDealsSum;

    public function rules()
    {
        $rules = collect(parent::rules());
        $rules->push([['assignedByCompany', 'countLoseDeal', 'countApologyDeal', 'countWonDeal', 'wonDealsSum'], 'number']);
        $rules->push([['countLoseDeal', 'countApologyDeal', 'countWonDeal', 'wonDealsSum'], 'default', 'value' => 0]);

        return $rules->toArray();
    }

    public static function mapFields()
    {
        $fields = collect(parent::mapFields());
        $fields->put('UF_CRM_1680707854', 'assignedByCompany');

        return $fields->toArray();
    }
}
