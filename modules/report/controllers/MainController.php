<?php

namespace app\modules\report\controllers;

use yii\base\BaseObject;
use yii\web\Controller;
use app\modules\report\models\ReportForm;
use yii\data\Pagination;

/**
 * Main controller for the `report` module
 */
class MainController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionInstallment()
    {
        $model = ReportForm::generate(\Yii::$app->user->identity->id, ['section' => 0]);

        $pagination = new Pagination([
            'defaultPageSize' => 50,
            'totalCount' => $model->amountStudent,
        ]);

        return $this->render('index', ['pages' => $pagination, 'students' => $model->students, 'model' => $model]);
    }

    public function actionAcquiring()
    {
        $model = ReportForm::generate(\Yii::$app->user->identity->id, ['section' => 1]);

        $pagination = new Pagination([
            'defaultPageSize' => 50,
            'totalCount' => $model->amountStudent,
        ]);

        return $this->render('index', ['pages' => $pagination, 'students' => $model->students, 'model' => $model]);
    }
}
