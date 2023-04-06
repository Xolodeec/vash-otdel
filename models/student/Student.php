<?php

namespace app\models\student;

use app\models\bitrix\crm\Contact;
use yii\base\Model;

class Student extends Contact
{
    public $assignedByCompany;

    public function rules()
    {
        $rules = collect(parent::rules());
        $rules->push(['assignedByCompany', 'number']);

        return $rules->toArray();
    }

    public static function mapFields()
    {
        $fields = collect(parent::mapFields());
        $fields->put('UF_CRM_1680707854', 'assignedByCompany');

        return $fields->toArray();
    }
}
