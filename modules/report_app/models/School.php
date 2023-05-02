<?php

namespace app\modules\report_app\models;

use app\models\bitrix\crm\Company;
use yii\base\Model;

class School extends Company
{
    public $countLoseDeal;
    public $countApologyDeal;
    public $countWonDeal;
    public $assignedByCompany;
    public $wonDealsSum;

    public function rules()
    {
        $rules = collect(parent::rules());
        $rules->push([['assignedByCompany', 'countLoseDeal', 'countApologyDeal', 'countWonDeal'], 'number']);
        $rules->push([['countLoseDeal', 'countApologyDeal', 'countWonDeal', 'wonDealsSum'], 'default', 'value' => 0]);

        return $rules->toArray();
    }

    public static function mapFields()
    {
        $fields = collect(parent::mapFields());

        return $fields->toArray();
    }

    public function getSum()
    {
        return 500;
    }
}
