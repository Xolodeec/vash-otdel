<?php

namespace app\models\profile;

use app\models\bitrix\Bitrix;
use app\models\bitrix\crm\Company;
use Tightenco\Collect\Support\Collection;
use yii\base\BaseObject;
use yii\helpers\ArrayHelper;

class Settings extends \app\models\bitrix\crm\Company
{
    public $reportPeriodicity;

    public function rules()
    {
        $rules = collect(parent::rules());
        $rules->push([['reportPeriodicity'], 'number']);
        $rules->push([['reportPeriodicity'], 'default', 'value' => 0]);
        $rules->push([['reportPeriodicity'], 'required']);

        return $rules->toArray();
    }

    public static function mapFields()
    {
        $mapFields = collect(parent::mapFields());
        $mapFields->put('UF_CRM_1681908293', 'reportPeriodicity');

        return $mapFields->toArray();
    }

    public function attributeLabels()
    {
        return [
            'reportPeriodicity' => 'Переодичность отчета',
        ];
    }

    public function save()
    {
        $bitrix = new Bitrix;

        return $bitrix->request('crm.company.update', ['id' => $this->id, 'fields' => static::getParamsField($this)]);
    }

    public function getListPeriodicity()
    {
        $bitrix = new Bitrix;

        ['result' => ['UF_CRM_1681908293' => $dataField]] = $bitrix->request('crm.company.fields');

        return ArrayHelper::map($dataField['items'], 'ID', 'VALUE');
    }
}
