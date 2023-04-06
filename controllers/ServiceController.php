<?php

namespace app\controllers;

use app\models\profile\Product;
use yii\filters\AccessControl;

class ServiceController extends MainController
{
    public $layout = 'main';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index', 'edit', 'create', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
                'denyCallback' => function($rule, $action) {
                    return $action->controller->redirect('login');
                },
            ],
        ];
    }

    public function actionIndex()
    {
        $products = Product::findByCompany(\Yii::$app->user->identity->id);

        return $this->render('index', ['products' => $products]);
    }

    public function actionEdit($id)
    {
        $model = Product::findById($id);

        if($model->companyId !== \Yii::$app->user->identity->id)
        {
            return $this->redirect('index');
        }

        if(\Yii::$app->request->isPost && $model->load(\Yii::$app->request->post()) && $model->validate())
        {
            $model->save();

            return $this->redirect('index');
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

            return $this->redirect('index');
        }

        return $this->render('create', ['model' => $model]);
    }

    public function actionDelete($id)
    {
        $model = Product::findById($id);

        if($model->companyId !== \Yii::$app->user->identity->id)
        {
            return $this->redirect('index');
        }

        $model->delete();

        return $this->redirect('index');
    }
}
