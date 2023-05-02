<?php

namespace app\modules\report\models;

use app\models\bitrix\Bitrix;
use Tightenco\Collect\Support\Collection;
use yii\base\Model;
use app\models\bitrix\crm\Deal;
use function Symfony\Component\String\u;

class ReportForm extends Model
{
    public $dateFrom;
    public $dateTo;
    public $page;
    public $amountStudent;
    public $students;
    public $companyId;
    public $companyName;

    public function rules()
    {
        return [
            [['page', 'amountStudent', 'companyId'], 'number'],
            [['amountStudent'], 'default', 'value' => 0],
            [['students'], 'default', 'value' => []],
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

        if (!empty($model->companyId)) {
            $companyId = $model->companyId;
        }

        $paramsRequest = [
            'order' => ['ID' => 'DESC'],
            'filter' => ['UF_CRM_1680707854' => $companyId],
            'select' => collect(Student::mapFields())->keys()->toArray(),
        ];

        $bitrix = new Bitrix;

        $response = $bitrix->request('crm.contact.list', $paramsRequest);

        $contacts = new Collection($response['result']);

        $model->amountStudent = $response['total'];

        if ($response['total'] > 50) {
            for ($i=50; $i<=$response['total']; $i+=50) {
                $paramsRequest['start'] = $i;

                $commandRow[] = $bitrix->buildCommand('crm.contact.list', $paramsRequest);
            }

            $additionalContacts = collect($bitrix->batchRequest($commandRow)['result']['result'])->flatten(1);
            $contacts = $contacts->merge($additionalContacts);

            unset($commandRow);
        }

        foreach ($contacts as $contact)
        {
            $paramsDeal = [
                'filter' => [
                        '=CONTACT_ID' => $contact['ID'],
                        '=CATEGORY_ID' => $categoryId,
                    ],
                'select' => collect(Deal::mapFields())->keys()->toArray(),
            ];

            $paramsDeal['filter']['>=DATE_CREATE'] = $model->dateFrom;
            $paramsDeal['filter']['<=DATE_CREATE'] = $model->dateTo;

            $commandRow[] = $bitrix->buildCommand('crm.deal.list', $paramsDeal);
        }

        $commandRow = array_chunk($commandRow, 50);

        $contactDeals = new Collection();

        foreach ($commandRow as $commands) {
            $contactDeals->push($bitrix->batchRequest($commands)['result']['result']);
        }

        $contactDeals = $contactDeals->flatten(2);
        $contactDeals = Deal::multipleCollect(new Deal(), $contactDeals->toArray());

        if($model->validate() && $response['total'] > 0)
        {
            $model->students = Student::multipleCollect(Student::class, $contacts->toArray());

            if(!empty($model->students))
            {
                $students = new Collection();

                $index = 0;
                foreach ($model->students as $student)
                {
                    $dealsByStudent = collect($contactDeals)->filter(function ($item) use($student, $categoryId, $params) {
                        return $item->contactId == $student->id && $item->categoryId == $categoryId;
                    });

                    if($dealsByStudent->isNotEmpty())
                    {
                        foreach ($dealsByStudent as $deal)
                        {
                            if(u($deal->stageId)->containsAny(['WON', 'C1:WON'])) {
                                $student->countWonDeal += 1;
                                $student->wonDealsSum += $deal->opportunity;
                            }
                            if(u($deal->stageId)->containsAny('APOLOGY')) $student->countApologyDeal += 1;
                            if(u($deal->stageId)->containsAny(['LOSE', 'C1:LOSE'])) $student->countLoseDeal += 1;
                        }
                    }

                    if ($student->countWonDeal > 0 || $student->countLoseDeal > 0 || $student->countApologyDeal > 0) {
                        $students->put($index + 1, $student);

                        $index++;
                    }
                }

                $model->students = $students->toArray();
            }
        }

        return $model;
    }
}