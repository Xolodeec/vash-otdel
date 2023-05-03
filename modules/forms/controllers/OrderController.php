<?php

namespace app\modules\forms\controllers;

use app\models\PayKeeper;
use app\modules\forms\models\order\InstallmentForm;
use app\modules\forms\models\order\OrderForm;
use app\modules\forms\models\order\AcquiringForm;
use Yii;
use yii\bootstrap5\ActiveForm;
use yii\web\Controller;
use yii\web\Response;
use yii\web\UploadedFile;

class OrderController extends Controller
{
    public $layout = 'main';

    public function actionInstallment($token)
    {
        $model = InstallmentForm::instanceByToken($token);

        if(!$model)
        {
            return $this->redirect('/login');
        }

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post()))
        {
            Yii::$app->response->format = Response::FORMAT_JSON;

            return ActiveForm::validate($model);
        }

        if(\Yii::$app->request->isPost && $model->load(\Yii::$app->request->post()) && $model->validate())
        {
            //$model->passportPhoto1 = UploadedFile::getInstance($model, 'passportPhoto1');
            //$model->passportPhoto2 = UploadedFile::getInstance($model, 'passportPhoto2');
            //$model->passportPhoto3 = UploadedFile::getInstance($model, 'passportPhoto3');
            //$model->passportPhoto4 = UploadedFile::getInstance($model, 'passportPhoto4');

            //$model->upload();
            $model->save();

            \Yii::$app->session->setFlash('success', 'Данные успешно отправлены');
        }

        return $this->render('installment', ['model' => $model]);
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
