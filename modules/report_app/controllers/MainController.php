<?php

namespace app\modules\report_app\controllers;

use app\modules\report_app\models\Client as App;
use yii\base\BaseObject;
use yii\web\Controller;
use Yii;
use app\models\bitrix\Bitrix;
use yii\web\Cookie;
use app\modules\report\models\ReportForm;
use app\modules\report_app\models\User;
use yii\data\Pagination;

class MainController extends Controller
{
    public $layout = 'main';

    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;

        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        if (User::checkIfDirector()) {

            $model = ReportForm::generate(0, 0, \Yii::$app->request->get());

            $pagination = new Pagination([
                'defaultPageSize' => 50,
                'totalCount' => $model->amountStudent,
            ]);

            return $this->render('index', ['pages' => $pagination, 'students' => $model->students, 'model' => $model]);
        } else {
            return $this->render('access_denied');
        }
    }

    public function actionAcquiring()
    {
        if (User::checkIfDirector()) {

            $model = ReportForm::generate(0, 1, \Yii::$app->request->get());

            $pagination = new Pagination([
                'defaultPageSize' => 50,
                'totalCount' => $model->amountStudent,
            ]);

            return $this->render('acquiring', ['pages' => $pagination, 'students' => $model->students, 'model' => $model]);
        } else {
            return $this->render('access_denied');
        }
    }

    public function actionInstall()
    {
        $data = Yii::$app->request->post();

        if(Yii::$app->request->isPost)
        {
            $app = new App($data);
            $app->updateConfig();

            /*
            $result = $app->request('placement.bind', [
                'PLACEMENT' => '',
                'HANDLER' => 'https://lk.vashotdel.ru/report-app/main/index',
                'LANG_ALL' => [
                    'ru' => [
                        'TITLE' => 'Отчёт',
                    ],
                ],
            ]);
            */
        }

        return $this->render("install");
    }

    public function actionAccessDenied()
    {
        return $this->render("/main/access_denied");
    }
}
