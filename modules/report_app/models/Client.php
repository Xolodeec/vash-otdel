<?php

namespace app\modules\report_app\models;

use app\models\bitrix\app\Client as App;

class Client extends App
{
    public static function getConfigPath()
    {
        return '/report_app/config/config.php';
    }
}