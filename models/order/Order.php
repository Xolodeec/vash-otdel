<?php

namespace app\models\order;

use app\models\bitrix\crm\Deal;
use function Symfony\Component\String\u;

class Order extends Deal
{
    public $product;
    public $_stages;
    public $contact;

}