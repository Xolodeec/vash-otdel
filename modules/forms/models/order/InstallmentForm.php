<?php

namespace app\modules\forms\models\order;

use app\models\bitrix\Bitrix;
use app\models\bitrix\crm\Deal;
use app\models\student\Student;
use app\modules\forms\models\order\OrderForm;
use yii\base\BaseObject;

class InstallmentForm extends OrderForm
{
    public $countMonthInstallment;
    public $codeWord;
    public $email;
    public $education;
    public $isChangeLastName;
    public $isMarried;
    public $previousLastName;
    public $fullNamePartner;
    public $birthdayPartner;
    public $fullNameContactPerson;
    public $phoneContactPerson;
    public $registrationCity;
    public $registrationStreet;
    public $registrationBuild;
    public $registrationRoom;
    public $residentialCity;
    public $residentialStreet;
    public $residentialBuild;
    public $residentialRoom;
    public $isRegistrationDataCompare;
    public $workNameCompany;
    public $workPhoneCompany;
    public $workCity;
    public $workStreet;
    public $workBuild;
    public $workPosition;
    public $amountMonthLastWork;
    public $salary;

    public function rules()
    {
        $rules  = collect(parent::rules());
        $rules->push(['email', 'email']);
        $rules->push([['previousLastName', 'fullNamePartner', 'birthdayPartner', 'fullNameContactPerson', 'phoneContactPerson', 'registrationCity', 'registrationStreet', 'registrationBuild', 'registrationRoom', 'residentialCity', 'residentialStreet', 'residentialBuild', 'residentialRoom', 'workNameCompany', 'workPhoneCompany', 'workCity', 'workStreet', 'workBuild', 'workPosition', 'amountMonthLastWork', 'salary', 'countMonthInstallment', 'codeWord'], 'string']);
        $rules->push(['previousLastName', 'required', 'when' => function($model){
            return $model->isChangeLastName == 1;
        }]);
        $rules->push([['email', 'education', 'isChangeLastName', 'isMarried', 'registrationCity', 'registrationStreet', 'registrationBuild', 'isRegistrationDataCompare', 'workNameCompany', 'workPhoneCompany', 'workCity', 'workStreet', 'workBuild', 'workPosition', 'amountMonthLastWork', 'salary', 'countMonthInstallment', 'codeWord'], 'required']);
        $rules->push([['isChangeLastName', 'isMarried', 'isRegistrationDataCompare'], 'boolean']);
        $rules->push([['fullNamePartner', 'birthdayPartner', 'fullNameContactPerson', 'phoneContactPerson'], 'required', 'when' => function($model){
            return $model->isMarried == 1;
        }]);
        $rules->push([['residentialCity', 'residentialStreet', 'residentialBuild'], 'required', 'when' => function($model){
            return $model->isRegistrationDataCompare != 1;
        }]);

        return $rules->toArray();
    }

    public function afterValidate()
    {
        parent::afterValidate();
    }

    public function validationPreviousLastName($attribute, $params)
    {
        if($this->isChangeLastName && empty($this->$attribute))
        {
            $this->addError($attribute, 'Поле должно быть заполнено');
        }
    }

    public function attributeLabels()
    {
        $labels = collect(parent::attributeLabels());
        $labels->put('education', 'Образование');
        $labels->put('isChangeLastName', 'Меняли ли вы фамилию?');
        $labels->put('isMarried', 'Вы женаты/замужем?');
        $labels->put('previousLastName', 'Ваша прежняя фамилия');
        $labels->put('fullNamePartner', 'ФИО мужа/жены');
        $labels->put('birthdayPartner', 'Дата рождения мужа/жены');
        $labels->put('fullNameContactPerson', 'ФИО контактного лица');
        $labels->put('phoneContactPerson', 'Телефон контактного лица');
        $labels->put('registrationCity', 'Город (прописка)');
        $labels->put('registrationStreet', 'Улица (прописка)');
        $labels->put('registrationBuild', 'Дом (прописка)');
        $labels->put('registrationRoom', 'Квартира (прописка)');
        $labels->put('residentialCity', 'Город (проживания)');
        $labels->put('residentialStreet', 'Улица (проживания)');
        $labels->put('residentialBuild', 'Дом (проживания)');
        $labels->put('residentialRoom', 'Квартира (проживания)');
        $labels->put('isRegistrationDataCompare', 'Адрес проживания совпадает с пропиской?');
        $labels->put('workNameCompany', 'Ваша работа, наименование организации');
        $labels->put('workPhoneCompany', 'Номер телефона организации (не мобильный)');
        $labels->put('workCity', 'Адрес организации, Город');
        $labels->put('workStreet', 'Улица');
        $labels->put('workBuild', 'Дом');
        $labels->put('workPosition', 'Должность');
        $labels->put('amountMonthLastWork', 'Кол-во мес. на последнем месте работы');
        $labels->put('salary', 'Ежемесячный доход');
        $labels->put('countMonthInstallment', 'Желаемый срок рассрочки, в месяцах');
        $labels->put('codeWord', 'Придумайте кодовое слово');

        return $labels->toArray();
    }

    public function getTypeEducation()
    {
        $bitrix = new Bitrix();

        ['result' => $result] = $bitrix->request('crm.contact.fields');

        if(collect($result)->get('UF_CRM_1683032242486'))
        {
            return $result['UF_CRM_1683032242486']['items'];
        }

        return [];
    }

    public function collectContact()
    {
        $student = new Student();
        $student->name = $this->name;
        $student->lastName = $this->lastName;
        $student->secondName = $this->secondName;
        $student->assignedByCompany = $this->company->id;
        $student->phone[] = ['VALUE' => $this->phone];
        $student->education = $this->education;
        $student->isChangeLastName = $this->isChangeLastName;
        $student->previousLastName = $this->previousLastName;
        $student->isMarried = $this->isMarried;
        $student->fullNamePartner = $this->fullNamePartner;
        $student->birthdayPartner = $this->birthdayPartner;
        $student->fullNameContactPerson = $this->fullNameContactPerson;
        $student->phoneContactPerson = $this->phoneContactPerson;
        $student->workNameCompany = $this->workNameCompany;
        $student->workPhoneCompany = $this->workPhoneCompany;
        $student->workPosition = $this->workPosition;
        $student->amountMonthLastWork = $this->amountMonthLastWork;
        $student->salary = $this->salary;
        $student->registrationAddress = "г. {$this->registrationCity}, ул. {$this->registrationStreet}, д. {$this->registrationBuild}";

        if(!empty($this->registrationRoom))
        {
            $student->registrationAddress .= ", кв. {$this->registrationRoom}";
        }

        $student->workAddress = "г. {$this->workCity}, ул. {$this->workStreet}, д. {$this->workBuild}";
        $student->isRegistrationDataCompare = $this->isRegistrationDataCompare;

        if(!$student->isRegistrationDataCompare)
        {
            $student->residentialAddress = "г. {$this->residentialCity}, ул. {$this->residentialStreet}, д. {$this->residentialBuild}";

            if(!empty($this->residentialRoom))
            {
                $student->residentialAddress .= ", кв. {$this->residentialRoom}";
            }
        }

        return $student;
    }

    public function collectDeal()
    {
        $deal = new Deal();
        $deal->companyId = $this->company->id;
        $deal->countMonthInstallment = $this->countMonthInstallment;
        $deal->codeWord = $this->codeWord;
        $deal->opportunity = $this->priceProduct;

        return $deal;
    }
}