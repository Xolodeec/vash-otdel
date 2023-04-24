<?php

namespace app\modules\forms\controllers;

use app\models\PayKeeper;
use app\modules\forms\models\order\OrderForm;
use app\modules\forms\models\order\AcquiringForm;
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

    public function actionAcquiring($token)
    {
        $model = AcquiringForm::instanceByToken($token);

        if(!$model)
        {
            return $this->redirect('/login');
        }

        if(\Yii::$app->request->isPost && $model->load(\Yii::$app->request->post()) && $model->validate())
        {
            $link = $model->createPaymentLink();
            $model->save();

            return $this->redirect($link);
        }

        return $this->render('acquiring', ['model' => $model]);
    }
}
