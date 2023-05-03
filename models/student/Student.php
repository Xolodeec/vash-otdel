<?php

namespace app\models\student;

use app\models\bitrix\crm\Contact;
use yii\base\Model;

class Student extends Contact
{
    public $assignedByCompany;
    public $education;
    public $isChangeLastName;
    public $isMarried;
    public $previousLastName;
    public $fullNamePartner;
    public $birthdayPartner;
    public $fullNameContactPerson;
    public $phoneContactPerson;
    public $workNameCompany;
    public $workPhoneCompany;
    public $workPosition;
    public $amountMonthLastWork;
    public $salary;
    public $registrationAddress;
    public $workAddress;
    public $isRegistrationDataCompare;
    public $residentialAddress;

    public function rules()
    {
        $rules = collect(parent::rules());
        $rules->push([['assignedByCompany', 'education', 'isChangeLastName', 'isMarried', 'isRegistrationDataCompare'], 'number']);
        $rules->push([['previousLastName', 'fullNamePartner', 'birthdayPartner', 'fullNameContactPerson', 'phoneContactPerson', 'workNameCompany', 'workPhoneCompany', 'workPosition', 'amountMonthLastWork', 'salary', 'registrationAddress', 'workAddress', 'residentialAddress'], 'string']);

        return $rules->toArray();
    }

    public static function mapFields()
    {
        $fields = collect(parent::mapFields());
        $fields->put('UF_CRM_1680707854', 'assignedByCompany');
        $fields->put('UF_CRM_1683032242486', 'education');
        $fields->put('UF_CRM_1683130672425', 'isChangeLastName');
        $fields->put('UF_CRM_1683130692506', 'isMarried');
        $fields->put('UF_CRM_1683130854038', 'previousLastName');
        $fields->put('UF_CRM_1683033078817', 'fullNamePartner');
        $fields->put('UF_CRM_1683033197', 'birthdayPartner');
        $fields->put('UF_CRM_1683033309092', 'fullNameContactPerson');
        $fields->put('UF_CRM_1683033360540', 'phoneContactPerson');
        $fields->put('UF_CRM_1683037610220', 'workNameCompany');
        $fields->put('UF_CRM_1683037736276', 'workPhoneCompany');
        $fields->put('UF_CRM_1683037878797', 'workPosition');
        $fields->put('UF_CRM_1683037903945', 'amountMonthLastWork');
        $fields->put('UF_CRM_1683037990942', 'salary');
        $fields->put('UF_CRM_1683134194206', 'registrationAddress');
        $fields->put('UF_CRM_1683134716507', 'workAddress');
        $fields->put('UF_CRM_1683135194616', 'isRegistrationDataCompare');
        $fields->put('UF_CRM_1683134237569', 'residentialAddress');

        return $fields->toArray();
    }
}
