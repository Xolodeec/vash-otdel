<?php

namespace app\modules\profile\controllers;

use app\modules\profile\models\Product;
use yii\base\BaseObject;

class ServiceController extends MainController
{
    public function actionEdit($id)
    {
        $model = Product::findById($id);

        if($model->companyId !== \Yii::$app->user->identity->id)
        {
            return $this->redirect('/profile/service');
        }

        if(\Yii::$app->request->isPost && $model->load(\Yii::$app->request->post()) && $model->validate())
        {
            $model->save();

            return $this->redirect('/profile/service');
        }

        return $this->render('edit', ['model' => $model]);
    }

    public function actionCreate()
    {
        $model = new Product();

        if(\Yii::$app->request->isPost && $model->load(\Yii::$app->request->post()) && $model->validate())
        {
            $model->companyId = \Yii::$app->user->identity->id;
            $model->save();

            return $this->redirect('/profile/service');
        }

        return $this->render('create', ['model' => $model]);
    }

    public function actionDelete($id)
    {
        $model = Product::findById($id);

        if($model->companyId !== \Yii::$app->user->identity->id)
        {
            return $this->redirect('/profile/service');
        }

        $model->delete();

        return $this->redirect('/profile/service');
    }
}
