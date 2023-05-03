<?php

namespace app\modules\forms\controllers;

use app\models\bitrix\crm\Product;
use yii\web\Controller;

/**
 * Default controller for the `forms` module
 */
class DefaultController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionGetProductPrice($id)
    {
        $product = Product::findById($id);

        return $product->price;
    }
}
