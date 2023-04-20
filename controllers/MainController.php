<?php

namespace app\controllers;

use app\models\order\OrderForm;
use app\models\student\StudentForm;
use yii\base\BaseObject;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\web\Controller;
use app\models\bitrix\Bitrix;
use app\models\bitrix\crm\Contact;

class MainController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index', 'students', 'orders'],
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

    public function actionStudents($page = null)
    {
        $model = StudentForm::generate(\Yii::$app->user->identity->id, \Yii::$app->request->get());

        $pagination = new Pagination([
            'defaultPageSize' => 50,
            'totalCount' => $model->amountStudent,
        ]);

        return $this->render('students', ['pages' => $pagination, 'students' => $model->students, 'model' => $model]);
    }

    public function actionOrders($page = null)
    {
        $model = OrderForm::generate(\Yii::$app->user->identity->id, \Yii::$app->request->get());

        $pagination = new Pagination([
            'defaultPageSize' => 50,
            'totalCount' => $model->amountOrder,
        ]);

        return $this->render('orders', ['pages' => $pagination, 'orders' => $model->orders, 'model' => $model]);
    }
}
