<?php

namespace app\models\order;

use app\models\bitrix\Bitrix;
use app\models\bitrix\crm\Deal;
use app\models\student\Student;
use Tightenco\Collect\Support\Collection;
use yii\base\Model;

class OrderForm extends Model
{
    public $page;
    public $amountOrder;
    public $orders;

    public function rules()
    {
        return [
            [['page', 'amountOrder'], 'number'],
            [['amountOrder'], 'default', 'value' => 0],
            [['orders'], 'default', 'value' => []],
        ];
    }

    public static function generate($companyId, $params = [])
    {
        $params = collect($params);

        $model = new static();
        $model->page = $params->has('page') ? $params->get('page') - 1 : 0;

        $paramsRequest = [
            'order' => ['ID' => 'DESC'],
            'filter' => ['COMPANY_ID' => $companyId],
            'select' => collect(Deal::mapFields())->keys()->toArray(),
            'start' => $model->page * 50,
        ];

        /*
        if($params->has('OrderForm') && $model->load($params->toArray()))
        {
            if(!empty($model->name)) $paramsRequest['filter']['%NAME'] = $model->name;
            if(!empty($model->lastName)) $paramsRequest['filter']['%LAST_NAME'] = $model->lastName;
        }
        */

        $bitrix = new Bitrix;

        $response = $bitrix->request('crm.deal.list', $paramsRequest);

        if($model->validate() && $response['total'] > 0)
        {
            $model->amountOrder = $response['total'];
            $model->orders = Deal::multipleCollect(Deal::class, $response['result']);

            if(!empty($model->orders))
            {
                $orders = new Collection();

                foreach ($model->orders as $index => $student)
                {
                    $orders->put($index + ($model->page * 50) + 1, $student);
                }

                $model->orders = $orders->toArray();
            }
        }

        return $model;
    }
}
