<?php

namespace app\modules\auth\models;

use app\models\bitrix\Bitrix;
use app\models\bitrix\crm\requisite\Requisite;
use app\models\school\School;
use Tightenco\Collect\Support\Collection;
use Yii;
use yii\base\Model;
use function Symfony\Component\String\u;

class SignUpForm extends Model
{
    public $typeCompany;
    public $titleCompany;
    public $inn;
    public $ogrn;
    public $phone;
    public $telegramPhone;
    public $ogrnIp;

    public function rules()
    {
        return [
            [['typeCompany'], 'number'],
            [['titleCompany', 'inn', 'ogrn', 'phone', 'telegramPhone', 'ogrnIp'], 'string'],
            [['titleCompany', 'inn', 'ogrn', 'phone', 'telegramPhone', 'ogrnIp'], 'filter', 'filter' => function($item){
                return u($item)->trim()->toString();
            }],
            [['phone', 'telegramPhone'], 'filter', 'filter' => function($item){
                return preg_replace('/[^0-9+]/', '', $item);
            }],
            ['phone', 'validationPhone'],
            [['typeCompany', 'titleCompany', 'phone', 'telegramPhone'], 'required'],
            ['inn', 'validationInn'],
            ['ogrn', 'validationOgrn'],
            ['ogrnIp', 'validationOgrnIp'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'typeCompany' => 'Тип компании',
            'titleCompany' => 'Название компании',
            'inn' => 'ИНН',
            'ogrn' => 'ОГРН',
            'phone' => 'Телефон',
            'telegramPhone' => 'Телеграм',
            'ogrnIp' => 'ОГРНИП',
        ];
    }

    public function validationInn($attribute)
    {
        if($this->typeCompany == 1 && u($this->$attribute)->length() !== 10)
        {
            $this->addError($attribute, 'ИНН должен состоять из 10 цифр');
        }

        if(($this->typeCompany == 2) && u($this->$attribute)->length() !== 12)
        {
            $this->addError($attribute, 'ИНН должен состоять из 12 цифр');
        }
    }

    public function validationOgrn($attribute)
    {
        if($this->typeCompany == 1 && u($this->$attribute)->length() !== 13 && !empty($this->$attribute))
        {
            $this->addError($attribute, 'ОГРН должен состоять из 13 цифр');
        }
    }

    public function validationOgrnIp($attribute)
    {
        if($this->typeCompany == 2 && u($this->$attribute)->length() !== 15 && !empty($this->$attribute))
        {
            $this->addError($attribute, 'ОГРНИП должен состоять из 15 цифр');
        }
    }

    public function validationPhone($attribute)
    {
        if(!empty(School::findDuplicateByPhone($this->$attribute)))
        {
            $this->addError($attribute, 'Пользователь с таким телефоном уже зарегистрирован.');
        }
    }

    public function save()
    {
        $bitrix = new Bitrix;
        $commands = new Collection();
        $password = \Yii::$app->security->generateRandomString(5);

        $uniqId = uniqid();

        $company = new School();
        $company->title = $this->titleCompany;
        $company->phone[] = ['VALUE' => "$this->phone", 'TYPE' => 'WORK'];
        $company->im[] = ['VALUE' => $this->telegramPhone, 'VALUE_TYPE' => 'TELEGRAM'];
        $company->password = \Yii::$app->security->generatePasswordHash($password);
        $company->tokenReferral = md5("{$password}:{$uniqId}");
        $company->referralLinkInstallment = Yii::$app->request->hostInfo . "/forms/order/installment?token={$company->tokenReferral}";
        $company->referralLinkAcquiring = Yii::$app->request->hostInfo . "/forms/order/acquiring?token={$company->tokenReferral}";

        $requisite = new Requisite;
        $requisite->presetId = $this->typeCompany;
        $requisite->inn = $this->inn;
        $requisite->ogrn = $this->ogrn;
        $requisite->entityTypeId = 4;
        $requisite->entityId = '$result[company_add]';
        $requisite->name = $this->titleCompany;
        if($this->typeCompany == 2) $requisite->ogrnIp = $this->ogrnIp;

        $commands->put('company_add', $bitrix->buildCommand('crm.company.add', ['fields' => $company::getParamsField($company)]));
        $commands->put('requisite_add', $bitrix->buildCommand('crm.requisite.add', ['fields' => $requisite::getParamsField($requisite)]));
        $commands->put('start_bizproc', $bitrix->buildCommand('bizproc.workflow.start', [
            'TEMPLATE_ID' => 19,
            'DOCUMENT_ID' => ['crm', 'CCrmDocumentCompany', '$result[company_add]'],
            'PARAMETERS' => [
                'password' => $password,
            ],
        ]));

        return $bitrix->batchRequest($commands->toArray());
    }
}
