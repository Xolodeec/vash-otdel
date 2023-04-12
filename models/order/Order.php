<?php

namespace app\models\order;

use app\models\bitrix\crm\Deal;

class Order extends Deal
{
    public $product;
    public $_stages;
    public $contact;
}