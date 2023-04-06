<?php

namespace app\modules\forms\controllers;

use app\modules\forms\models\order\OrderForm;
use yii\web\Controller;

class OrderController extends Controller
{
    public $layout = 'main';

    public function actionIndex($token)
    {
        $model = OrderForm::instanceByToken($token);

        if(!$model)
        {
            return $this->redirect('/login');
        }

        if(\Yii::$app->request->isPost && $model->load(\Yii::$app->request->post()) && $model->validate())
        {
            $model->save();

            \Yii::$app->session->setFlash('success', 'Данные успешно отправлены');
        }

        return $this->render('index', ['model' => $model]);
    }
}
