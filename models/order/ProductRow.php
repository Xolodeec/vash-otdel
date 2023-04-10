<?php

namespace app\models\order;

use app\models\bitrix\crm\Product;

class ProductRow extends Product
{
    public $title;
    public $ownerId;

    public function rules()
    {
        $rules = collect(parent::rules());
        $rules->push([['title', 'ownerId'], 'string']);

        return $rules->toArray();
    }

    public static function mapFields()
    {
        $mapFields = collect(parent::mapFields());
        $mapFields->put('PRODUCT_NAME', 'title');
        $mapFields->put('OWNER_ID', 'ownerId');

        return $mapFields->toArray();
    }
}