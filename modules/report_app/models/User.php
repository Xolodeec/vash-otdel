<?php

namespace app\modules\report_app\models;

use app\models\bitrix\Bitrix;

class User
{
    public static function checkIfDirector()
    {
        $bitrix = new Bitrix();

        $commandRow['user'] = $bitrix->buildCommand('user.current');

        $commandRow['departments'] = $bitrix->buildCommand('department.get', [
//            'ID' => 1
        ]);

        ['result' => ['result' => $respone]] = $bitrix->batchRequest($commandRow);

        foreach ($respone['departments'] as $department) {
            if (isset($department['UF_HEAD']) && $department['UF_HEAD'] == $respone['user']['ID']) {
                return true;
            }
        }

        return false;
    }
}