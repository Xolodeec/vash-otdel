<?php

namespace app\models\profile;

use app\models\bitrix\Bitrix;
use app\models\bitrix\crm\requisite\Address;
use app\models\bitrix\crm\requisite\BankRequisite;
use Tightenco\Collect\Support\Collection;
use yii\base\BaseObject;

class Requisite extends \app\models\bitrix\crm\requisite\Requisite
{
    public $bankDetails;
    public $legalAddress;
    public $actualAddress;

    public function attributeLabels()
    {
        return [
            'inn' => 'ИНН',
            'ogrn' => 'ОГРН',
            'directorName' => 'ФИО Ген.дира',
        ];
    }

    public function rules()
    {
        $rules = collect(parent::rules());
        $rules->push([['legalAddress', 'actualAddress'], 'default', 'value' => function($item){
            $model = new Address();
            $model->validate();

            return $model;
        }]);

        return $rules->toArray();
    }


    public static function findByCompanyId($companyId)
    {
        $bitrix = new Bitrix;
        $model = new static();
        $commands = new Collection();

        $commands->put('get_requisite', $bitrix->buildCommand('crm.requisite.list', ['filter' => ['ENTITY_TYPE_ID' => 4, 'ENTITY_ID' => $companyId]]));
        $commands->put('get_bank_details', $bitrix->buildCommand('crm.requisite.bankdetail.list', ['filter' => ['ENTITY_ID' => '$result[get_requisite][0][ID]']]));
        $commands->put('get_address', $bitrix->buildCommand('crm.address.list', ['filter' => ['ENTITY_ID' =>'$result[get_requisite][0][ID]']]));

        ['result' => ['result' => $result]] = $bitrix->batchRequest($commands->toArray());

        $result = collect($result);

        if(!empty($result->get('get_requisite')[0]) && $model::collect($model, $result->get('get_requisite')[0]))
        {
            $bankDetails = new BankRequisite();
            $address = new Address();

            if(!empty($result->get('get_bank_details')[0]))
            {
                $bankDetails::collect($bankDetails, $result->get('get_bank_details')[0]);
            }

            if(!empty($result->get('get_address')[0]))
            {
                $address = $address::multipleCollect(Address::class, $result->get('get_address'));

                $legalAddress = collect($address)->search(function ($item){
                    return $item->typeId == 6;
                });

                if($legalAddress !== false)
                {
                    $model->legalAddress = $address[$legalAddress];
                }

                $actualAddress = collect($address)->search(function ($item){
                    return $item->typeId == 1;
                });

                if($actualAddress !== false)
                {
                    $model->actualAddress = $address[$actualAddress];
                }
            }

            $model->legalAddress->typeId = 6;
            $model->actualAddress->typeId = 1;

            $model->bankDetails = $bankDetails;

            return $model;
        }

        return false;
    }
}
