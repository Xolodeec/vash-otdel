<?php

namespace app\models;

use app\models\school\School;
use Yii;
use yii\base\BaseObject;

class User extends BaseObject implements \yii\web\IdentityInterface
{
    public $id;
    public $title;
    public $password;
    public $authKey;
    public $accessToken;
    public $phone;
    public $referralLinkInstallment;
    public $referralLinkAcquiring;

    public static function findIdentity($id)
    {
        $company = School::findById($id);

        if($company)
        {
            $user = new static();
            $user->id = $company->id;
            $user->title = $company->title;
            $user->password = $company->password;
            $user->phone = $company->phone[0]['VALUE'];
            $user->referralLinkInstallment = $company->referralLinkInstallment;
            $user->referralLinkAcquiring = $company->referralLinkAcquiring;

            return $user;
        }

        return null;
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null;
    }

    public static function findByPhone($phone)
    {
        $company = School::findByPhone($phone);

        if($company)
        {
            $user = new static();
            $user->id = $company->id;
            $user->title = $company->title;
            $user->password = $company->password;

            return $user;
        }

        return null;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->authKey;
    }

    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    public function validatePassword($password)
    {
        return Yii::$app->getSecurity()->validatePassword($password, $this->password);
    }
}
