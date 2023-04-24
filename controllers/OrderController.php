<?php

namespace app\controllers;

use app\models\order\OrderForm;
use app\modules\report\models\ReportForm;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\web\Controller;

class OrderController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['installment', 'acquiring'],
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

    public function actionInstallment($page = null)
    {
        $model = OrderForm::generate(\Yii::$app->user->identity->id, 0, \Yii::$app->request->get());

        $pagination = new Pagination([
            'defaultPageSize' => 50,
            'totalCount' => $model->amountOrder,
        ]);

        return $this->render('installment', ['pages' => $pagination, 'orders' => $model->orders, 'model' => $model]);
    }

    public function actionAcquiring($page = null)
    {
        $model = OrderForm::generate(\Yii::$app->user->identity->id, 1, \Yii::$app->request->get());

        $pagination = new Pagination([
            'defaultPageSize' => 50,
            'totalCount' => $model->amountOrder,
        ]);

        return $this->render('acquiring', ['pages' => $pagination, 'orders' => $model->orders, 'model' => $model]);
    }
}
