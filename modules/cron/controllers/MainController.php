<?php

namespace app\modules\cron\controllers;

use app\modules\report\models\ReportForm;
use app\modules\cron\models\Report;
use Google\Service\CloudSourceRepositories\Repo;
use yii\web\Controller;

/**
 * Default controller for the `cron` module
 */
class MainController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionReport()
    {
        $report = new Report;

        $report->sendTextReport();

        return 200;
    }
}
