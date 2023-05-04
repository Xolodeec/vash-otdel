<?php

namespace app\modules\cron\models;

use app\models\TelegramBot;
use app\modules\report\models\ReportForm;
use app\models\bitrix\Bitrix;
use Tightenco\Collect\Support\Collection;
use yii\base\Model;

class Report extends Model
{
    public function sendTextReport()
    {
        $bitrix = new Bitrix();

        $companies = $this->getCompanies();

        if (date('d') == 1 && !empty($companies['28']))
        {
            $dateFrom = date('d.m.Y', strtotime('first day of previous month'));
            $dateTo = date('d.m.Y', strtotime('last day of previous month'));

            $students = $this->getStudents($companies['28'], $dateFrom, $dateTo);

            foreach ($companies['28'] as $key => $company)
            {
                $text = "Рассрочка\n\n";

                foreach ($students[$key]['installment'] as $student) {
                    $text .= "$student->secondName $student->name $student->lastName \n";
                    $text .= "Авторизовано договоров: $student->countWonDeal \n";
                    $text .= "Отказов клиента: $student->countLoseDeal \n";
                    $text .= "Отказов банка: $student->countApologyDeal \n\n";
                }

                $text .= "Эквайринг\n\n";

                foreach ($students[$key]['acquiring'] as $student)
                {
                    $text .= "$student->secondName $student->name $student->lastName \n";
                    $text .= "Авторизовано договоров: $student->countWonDeal \n";
                    $text .= "Отказов клиента: $student->countLoseDeal \n";
                    $text .= "Отказов банка: $student->countApologyDeal \n\n";
                }

                $companyId = $company['ID'];

                /*
                $commandRow[] = $bitrix->buildCommand('bizproc.workflow.start', [
                    'TEMPLATE_ID' => 20,
                    'DOCUMENT_ID' => ['crm', 'CCrmDocumentCompany', "COMPANY_$companyId"],
                    'PARAMETERS' => [
                        'text' => $text
                    ]
                ]);
                */

                if(!empty($company['UF_CRM_1683203303333']))
                {
                    $tgBot = TelegramBot::vashOtdel();
                    $tgBot->sendMessage($company->telegramId, $text);
                }
            }
        }

        if (date('N') == 1 && !empty($companies['27']))
        {
            $dateFrom = date('d.m.Y', strtotime('monday previous week'));
            $dateTo = date('d.m.Y', strtotime('sunday previous week'));

            $students = $this->getStudents($companies['27'], $dateFrom, $dateTo);

            foreach ($companies['27'] as $key => $company) {
                $text = "Рассрочка\n\n";

                foreach ($students[$key]['installment'] as $student) {
                    $text .= "$student->secondName $student->name $student->lastName \n";
                    $text .= "Авторизовано договоров: $student->countWonDeal \n";
                    $text .= "Отказов клиента: $student->countLoseDeal \n";
                    $text .= "Отказов банка: $student->countApologyDeal \n\n";
                }

                $text .= "Эквайринг\n\n";

                foreach ($students[$key]['acquiring'] as $student) {
                    $text .= "$student->secondName $student->name $student->lastName \n";
                    $text .= "Авторизовано договоров: $student->countWonDeal \n";
                    $text .= "Отказов клиента: $student->countLoseDeal \n";
                    $text .= "Отказов банка: $student->countApologyDeal \n\n";
                }

                $companyId = $company['ID'];

                /*
                $commandRow[] = $bitrix->buildCommand('bizproc.workflow.start', [
                    'TEMPLATE_ID' => 20,
                    'DOCUMENT_ID' => ['crm', 'CCrmDocumentCompany', "COMPANY_$companyId"],
                    'PARAMETERS' => [
                        'text' => $text
                    ]
                ]);
                */

                if(!empty($company['UF_CRM_1683203303333']))
                {
                    $tgBot = TelegramBot::vashOtdel();
                    $tgBot->sendMessage($company->telegramId, $text);
                }
            }
        }

        if (!empty($companies['26']))
        {
            $dateFrom = date('d.m.Y', strtotime('-1 day'));
            $dateTo = date('d.m.Y', strtotime('-1 day'));

            $students = $this->getStudents($companies['26'], $dateFrom, $dateTo);

            foreach ($companies['26'] as $key => $company)
            {
                $text = "Рассрочка\n\n";

                foreach ($students[$key]['installment'] as $student) {
                    $text .= "$student->secondName $student->name $student->lastName \n";
                    $text .= "Авторизовано договоров: $student->countWonDeal \n";
                    $text .= "Отказов клиента: $student->countLoseDeal \n";
                    $text .= "Отказов банка: $student->countApologyDeal \n\n";
                }

                $text .= "Эквайринг\n\n";

                foreach ($students[$key]['acquiring'] as $student) {
                    $text .= "$student->secondName $student->name $student->lastName \n";
                    $text .= "Авторизовано договоров: $student->countWonDeal \n";
                    $text .= "Отказов клиента: $student->countLoseDeal \n";
                    $text .= "Отказов банка: $student->countApologyDeal \n\n";
                }

                $companyId = $company['ID'];

                /*
                $commandRow[] = $bitrix->buildCommand('bizproc.workflow.start', [
                    'TEMPLATE_ID' => 20,
                    'DOCUMENT_ID' => ['crm', 'CCrmDocumentCompany', "COMPANY_$companyId"],
                    'PARAMETERS' => [
                        'text' => $text
                    ]
                ]);
                */

                if(!empty($company['UF_CRM_1683203303333']))
                {
                    $tgBot = TelegramBot::vashOtdel();
                    $tgBot->sendMessage($company->telegramId, $text);
                }
            }
        }

        if (!empty($commandRow))
        {
            $commandRow = array_chunk($commandRow, 50);

            foreach ($commandRow as $key => $commands) {
                $bitrix->batchRequest($commands);
            }
        }
    }

    public function getCompanies()
    {
        $companies = new Collection();

        $bitrix = new Bitrix();

        ['total' => $count] = $bitrix->request('crm.company.list', [
            'filter' => [
                '!=UF_CRM_1681908293' => ['', 29]
            ]
        ]);

        for ($i=0; $i < $count; $i += 50) {
            $commandRow[] = $bitrix->buildCommand('crm.company.list', [
                'select' => ['UF_CRM_1681908293'],
                'filter' => [
                    '!=UF_CRM_1681908293' => ['', 29]
                ],
                'start' => $i
            ]);
        }

        $commandRow = array_chunk($commandRow, 50);

        foreach ($commandRow as $commands) {
            $companies->push($bitrix->batchRequest($commands)['result']['result']);
        }

        $companies = $companies->flatten(2)->groupBy('UF_CRM_1681908293');

        return $companies;
    }

    public function getStudents($companies, $dateFrom, $dateTo)
    {
        $params['ReportForm'] = [
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo,
        ];

        foreach ($companies as $key => $company) {
            $model = ReportForm::generate($company['ID'], 0, $params);

            $students[$key]['installment'] = $model->students;

            if ($model->amountStudent > 50) {
                for ($i=1; $i * 50 <= $model->amountStudent; $i++) {
                    $params['page'] = $i + 1;

                    $model = ReportForm::generate($company['ID'], 0, $params);

                    $students[$key]['installment'] += $model->students;
                }
            }
            unset($params['page']);

            $model = ReportForm::generate($company['ID'], 1, $params);

            $students[$key]['acquiring'] = $model->students;

            if ($model->amountStudent > 50) {
                for ($i=1; $i * 50 <= $model->amountStudent; $i++) {
                    $params['page'] = $i + 1;

                    $model = ReportForm::generate($company['ID'], 1, $params);

                    $students[$key]['acquiring'] += $model->students;
                }
            }
        }

        return $students;
    }
}