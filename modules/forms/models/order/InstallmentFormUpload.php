<?php

namespace app\modules\forms\models\order;

use app\models\bitrix\Bitrix;
use app\models\bitrix\crm\Deal;
use app\models\student\Student;
use app\modules\forms\models\order\OrderForm;
use yii\base\BaseObject;

class InstallmentFormUpload extends InstallmentForm
{
    public $passportPhoto1;
    public $passportPhoto2;
    public $passportPhoto3;
    public $passportPhoto4;
    public $passportPhoto1Path;
    public $passportPhoto2Path;
    public $passportPhoto3Path;
    public $passportPhoto4Path;

    public function rules()
    {
        $rules  = collect(parent::rules());
        $rules->push([['passportPhoto1', 'passportPhoto2', 'passportPhoto3', 'passportPhoto4'], 'file', 'extensions' => ['png', 'jpg', 'jpeg']]);
        $rules->push([['passportPhoto1', 'passportPhoto2', 'passportPhoto3', 'passportPhoto4'], 'required']);

        return $rules->toArray();
    }

    public function attributeLabels()
    {
        $labels = collect(parent::attributeLabels());

        $labels->put('passportPhoto1', 'Фото 2-3 странице паспорта в развороте');
        $labels->put('passportPhoto2', 'Фото страницы паспорта с действующей регистрацией');
        $labels->put('passportPhoto3', 'Сделайте селфи с паспортом');
        $labels->put('passportPhoto4', 'Сделайте селфи с разворотом паспорта на странице 18-19');

        return $labels->toArray();
    }

    public function collectContact()
    {
        $student = parent::collectContact();
        $student->passportPhoto1 = ['fileData' => [basename($this->passportPhoto1Path), base64_encode(file_get_contents(\Yii::getAlias("@web") . $this->passportPhoto1Path))]];
        $student->passportPhoto2 = ['fileData' => [basename($this->passportPhoto2Path), base64_encode(file_get_contents(\Yii::getAlias("@web") . $this->passportPhoto2Path))]];
        $student->passportPhoto3 = ['fileData' => [basename($this->passportPhoto3Path), base64_encode(file_get_contents(\Yii::getAlias("@web") . $this->passportPhoto3Path))]];
        $student->passportPhoto4 = ['fileData' => [basename($this->passportPhoto4Path), base64_encode(file_get_contents(\Yii::getAlias("@web") . $this->passportPhoto4Path))]];

        return $student;
    }


    public function upload()
    {
        if($this->validate())
        {
            $this->passportPhoto1->saveAs(\Yii::getAlias("@web") . "src/document/{$this->passportPhoto1->baseName}.{$this->passportPhoto1->extension}");
            $this->passportPhoto1Path = \Yii::getAlias("@web") . "src/document/{$this->passportPhoto1->baseName}.{$this->passportPhoto1->extension}";

            $this->passportPhoto2->saveAs(\Yii::getAlias("@web") . "src/document/{$this->passportPhoto2->baseName}.{$this->passportPhoto2->extension}");
            $this->passportPhoto2Path = \Yii::getAlias("@web") . "src/document/{$this->passportPhoto2->baseName}.{$this->passportPhoto2->extension}";

            $this->passportPhoto3->saveAs(\Yii::getAlias("@web") . "src/document/{$this->passportPhoto3->baseName}.{$this->passportPhoto3->extension}");
            $this->passportPhoto3Path = \Yii::getAlias("@web") . "src/document/{$this->passportPhoto3->baseName}.{$this->passportPhoto3->extension}";

            $this->passportPhoto4->saveAs(\Yii::getAlias("@web") . "src/document/{$this->passportPhoto4->baseName}.{$this->passportPhoto4->extension}");
            $this->passportPhoto4Path = \Yii::getAlias("@web") . "src/document/{$this->passportPhoto4->baseName}.{$this->passportPhoto4->extension}";

            return true;
        }

        return false;
    }
}