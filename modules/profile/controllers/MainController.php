<?php

namespace app\modules\profile\controllers;

use app\modules\profile\models\Product;
use app\modules\profile\models\Requisite;
use yii\filters\AccessControl;
use yii\web\Controller;

class MainController extends Controller
{
    public $layout = 'main';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index', 'service', 'requisite', 'bank-detail', 'edit', 'create', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
                'denyCallback' => function($rule, $action) {
                    return $action->controller->redirect('/login');
                },
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionService()
    {
        $products = Product::findByCompany(\Yii::$app->user->identity->id);

        return $this->render('services', ['products' => $products]);
    }

    public function actionRequisite()
    {
        $model = Requisite::findByCompanyId(\Yii::$app->user->identity->id);

        if(\Yii::$app->request->isPost && $model->load(\Yii::$app->request->post()) && $model->validate())
        {
            $model->save();
        }

        return $this->render('requisite', ['model' => $model]);
    }

    public function actionBankDetail()
    {
        $model = Requisite::findByCompanyId(\Yii::$app->user->identity->id);

        if(\Yii::$app->request->isPost && $model->bankDetails->load(\Yii::$app->request->post()) && $model->validate())
        {
            $model->bankDetails->save();
        }

        return $this->render('bank-details', ['model' => $model]);
    }
}
