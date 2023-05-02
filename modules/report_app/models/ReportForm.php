<?php

namespace app\modules\report_app\models;

use app\models\bitrix\Bitrix;
use Tightenco\Collect\Support\Collection;
use yii\base\Model;
use app\models\bitrix\crm\Deal;
use app\models\bitrix\crm\Company;
use function Symfony\Component\String\u;

class ReportForm extends Model
{
    public $dateFrom;
    public $dateTo;
    public $page;
    public $amountschool;
    public $schools;
    public $companyId;
    public $companyName;
    public $countWonDeal;
    public $countLoseDeal;
    public $countApologyDeal;
    public $wonDealsSum;

    public function rules()
    {
        return [
            [['page', 'amountschool', 'companyId', 'countWonDeal', 'countLoseDeal', 'countApologyDeal', 'wonDealsSum'], 'number'],
            [['amountschool', 'countWonDeal', 'countLoseDeal', 'countApologyDeal', 'wonDealsSum'], 'default', 'value' => 0],
            [['schools'], 'default', 'value' => []],
            [['dateFrom', 'dateTo', 'companyName'], 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'dateFrom' => 'Дата С',
            'dateTo' => 'Дата ПО',
        ];
    }

    public static function generate($companyId, $categoryId, $params = [])
    {
        $params = collect($params);

        $model = new static();

        if($params->has('ReportForm'))
        {
            $model->load($params->toArray());
        }

        if(empty($model->dateFrom)) $model->dateFrom = date('Y-m-d',strtotime('-1 days'));
        if(empty($model->dateTo)) $model->dateTo = date('Y-m-d',strtotime('-1 days'));

        $paramsRequest = [
            'order' => ['ID' => 'DESC'],
            'select' => collect(School::mapFields())->keys()->toArray(),
        ];

        if (!empty($model->companyId)) {
            $paramsRequest['filter'] = ['ID' => $model->companyId];
        }

        $bitrix = new Bitrix;

        $response = $bitrix->request('crm.company.list', $paramsRequest);

        $companies = new Collection($response['result']);

        $model->amountschool = $response['total'];

        if ($response['total'] > 50) {
            for ($i=50; $i<=$response['total']; $i+=50) {
                $paramsRequest['start'] = $i;

                $commandRow[] = $bitrix->buildCommand('crm.company.list', $paramsRequest);
            }

            $additionalCompanies = collect($bitrix->batchRequest($commandRow)['result']['result'])->flatten(1);
            $companies = $companies->merge($additionalCompanies);

            unset($commandRow);
        }

        foreach ($companies as $company)
        {
            $paramsDeal = [
                'filter' => [
                    '=COMPANY_ID' => $company['ID'],
                    '=CATEGORY_ID' => $categoryId,
                ],
                'select' => collect(Deal::mapFields())->keys()->toArray(),
            ];

            $paramsDeal['filter']['>=DATE_CREATE'] = $model->dateFrom;
            $paramsDeal['filter']['<=DATE_CREATE'] = date("d.m.Y 23:59", strtotime($model->dateTo));

            $commandRow[] = $bitrix->buildCommand('crm.deal.list', $paramsDeal);
        }

        $commandRow = array_chunk($commandRow, 50);

        $companyDeals = new Collection();
        $companyDealsCount = new Collection();

        foreach ($commandRow as $commands) {
            $dealsResponse = $bitrix->batchRequest($commands)['result'];

            $companyDealsCount->push($dealsResponse['result_total']);
            $companyDeals->push($dealsResponse['result']);
        }

        unset($commandRow);

        $companyDealsCount = $companyDealsCount->flatten(1);
        $companyDeals = $companyDeals->flatten(1);


        foreach ($companyDealsCount as $key => $count) {
            if ($count > 50) {
                $paramsDeal = [
                    'filter' => [
                        '=COMPANY_ID' => $companies[$key]['ID'],
                        '=CATEGORY_ID' => $categoryId,
                    ],
                    'select' => collect(Deal::mapFields())->keys()->toArray(),
                ];

                $paramsDeal['filter']['>=DATE_CREATE'] = $model->dateFrom;
                $paramsDeal['filter']['<=DATE_CREATE'] = date("d.m.Y 23:59", strtotime($model->dateTo));

                for ($i=50; $i<=$count; $i+=50) {
                    $paramsDeal['start'] = $i;

                    $commandRow[] = $bitrix->buildCommand('crm.deal.list', $paramsDeal);
                }

                $additionalDeals = collect($bitrix->batchRequest($commandRow)['result']['result'])->flatten(1);
                $companyDeals->push($additionalDeals->toArray());
            }
        }

        $companyDeals = $companyDeals->flatten(1);
        $companyDeals = Deal::multipleCollect(new Deal(), $companyDeals->toArray());

        if($model->validate() && $response['total'] > 0)
        {
            $model->schools = School::multipleCollect(School::class, $companies->toArray());

            if(!empty($model->schools))
            {
                $schools = new Collection();

                $index = 0;
                foreach ($model->schools as $school)
                {
                    $dealsBySchool = collect($companyDeals)->filter(function ($item) use($school, $categoryId) {
                        return $item->companyId == $school->id && $item->categoryId == $categoryId;
                    });

                    if($dealsBySchool->isNotEmpty())
                    {
                        foreach ($dealsBySchool as $deal)
                        {
                            if(u($deal->stageId)->containsAny(['WON', 'C1:WON'])) {
                                $school->countWonDeal += 1;
                                $school->wonDealsSum += $deal->opportunity;
                                $model->countWonDeal += 1;
                                $model->wonDealsSum += $deal->opportunity;
                            }
                            if(u($deal->stageId)->containsAny('APOLOGY')) {
                                $school->countApologyDeal += 1;
                                $model->countApologyDeal += 1;
                            }
                            if(u($deal->stageId)->containsAny(['LOSE', 'C1:LOSE'])) {
                                $school->countLoseDeal += 1;
                                $model->countLoseDeal += 1;
                            }
                        }
                    }

                    if ($school->countWonDeal > 0 || $school->countLoseDeal > 0 || $school->countApologyDeal > 0) {
                        $schools->put($index + 1, $school);

                        $index++;
                    }
                }

                $model->schools = $schools->toArray();
            }
        }

        return $model;
    }

}