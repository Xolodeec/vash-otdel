<?php

namespace app\controllers;

use app\models\profile\Requisite;
use yii\filters\AccessControl;
use yii\web\Controller;

class ProfileController extends Controller
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
        $model = Requisite::findByCompanyId(\Yii::$app->user->identity->id);

        return $this->render('index', ['model' => $model]);
    }

    public function actionRequisite()
    {
        $model = Requisite::findByCompanyId(\Yii::$app->user->identity->id);

        if(\Yii::$app->request->isPost && $model->load(\Yii::$app->request->post()) && $model->validate())
        {
            $model->save();
        }

        return $this->redirect('/profile');
    }

    public function actionBankDetail()
    {
        $model = Requisite::findByCompanyId(\Yii::$app->user->identity->id);

        if(\Yii::$app->request->isPost && $model->bankDetails->load(\Yii::$app->request->post()) && $model->validate())
        {
            $model->bankDetails->save();
        }

        return $this->redirect('/profile');
    }
}
