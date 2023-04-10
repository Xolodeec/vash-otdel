<?php

namespace app\models\order;

use app\models\bitrix\Bitrix;
use app\models\bitrix\crm\Deal;
use app\models\bitrix\crm\Product;
use app\models\student\Student;
use Tightenco\Collect\Support\Collection;
use yii\base\Model;
use yii\helpers\ArrayHelper;

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

        $bitrix = new Bitrix;

        $command['get_deal'] = $bitrix->buildCommand('crm.deal.list', $paramsRequest);
        $command['get_stages'] = $bitrix->buildCommand('crm.status.list', ['filter' => ['CATEGORY_ID' => 0, 'ENTITY_ID' => 'DEAL_STAGE']]);

        ['result' => $response] = $bitrix->batchRequest($command);

        if($model->validate() && $response['result_total']['get_deal'] > 0)
        {
            $model->amountOrder = $response['result_total']['get_deal'];
            $model->orders = Order::multipleCollect(Order::class, $response['result']['get_deal']);

            if(!empty($model->orders))
            {
                $orders = new Collection();

                foreach ($model->orders as $index => $order)
                {
                    $order->_stages = ArrayHelper::map($response['result']['get_stages'], 'STATUS_ID', 'NAME');

                    $orders->put($index + ($model->page * 50) + 1, $order);
                    $commandsGetProduct[$order->id] = $bitrix->buildCommand('crm.deal.productrows.get', ['id' => $order->id]);
                }

                ['result' => ['result' => $products]] = $bitrix->batchRequest($commandsGetProduct);
                $products = collect($products)->flatten(1)->toArray();
                $products = collect(ProductRow::multipleCollect(ProductRow::class, $products));

                foreach ($model->orders as $index => &$order)
                {
                    $indexProductDeal = $products->search(function ($item) use($order){
                        return $item->ownerId == $order->id;
                    });

                    if($indexProductDeal !== false)
                    {
                        $order->product = $products->get($indexProductDeal);
                    }
                }

                $model->orders = $orders->toArray();
            }
        }

        return $model;
    }
}
