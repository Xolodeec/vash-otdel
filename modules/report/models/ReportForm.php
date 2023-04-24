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

//        dd($categoryId);

        $model = new static();
        $model->page = $params->has('page') ? $params->get('page') - 1 : 0;

        if($params->has('ReportForm'))
        {
            $model->load($params->toArray());
        }

        if (!empty($model->companyId)) {
            $companyId = $model->companyId;
        }

        $paramsRequest = [
            'order' => ['ID' => 'DESC'],
            'filter' => ['UF_CRM_1680707854' => $companyId],
            'select' => collect(Student::mapFields())->keys()->toArray(),
            'start' => $model->page * 50,
        ];

        $bitrix = new Bitrix;

        $response = $bitrix->request('crm.contact.list', $paramsRequest);

        foreach ($response['result'] as $contact)
        {
            $paramsDeal = [
                'filter' => [
                        '=CONTACT_ID' => $contact['ID'],
                        'CATEGORY_ID' => $categoryId,
                    ],
                'select' => collect(Deal::mapFields())->keys()->toArray(),
            ];

            if(!empty($model->dateFrom)) $paramsDeal['filter']['>=DATE_CREATE'] = $model->dateFrom;
            if(!empty($model->dateTo)) $paramsDeal['filter']['<=DATE_CREATE'] = $model->dateTo;

            $commandRow[] = $bitrix->buildCommand('crm.deal.list', $paramsDeal);
        }

        ['result' => ['result' => $contactDeals]] = $bitrix->batchRequest($commandRow);

        $contactDeals = collect($contactDeals)->flatten(1);
        $contactDeals = Deal::multipleCollect(new Deal(), $contactDeals->toArray());

        if($model->validate() && $response['total'] > 0)
        {
            $model->amountStudent = $response['total'];
            $model->students = Student::multipleCollect(Student::class, $response['result']);

            if(!empty($model->students))
            {
                $students = new Collection();

                foreach ($model->students as $index => $student)
                {
                    $dealsByStudent = collect($contactDeals)->filter(function ($item) use($student, $params) {
                        return $item->contactId == $student->id && $item->categoryId == $params['category'];
                    });

                    if($dealsByStudent->isNotEmpty())
                    {
                        foreach ($dealsByStudent as $deal)
                        {
                            if(u($deal->stageId)->containsAny('WON')) $student->countWonDeal += 1;
                            if(u($deal->stageId)->containsAny('APOLOGY')) $student->countApologyDeal += 1;
                            if(u($deal->stageId)->containsAny('LOSE')) $student->countLoseDeal += 1;
                        }
                    }

                    $students->put($index + ($model->page * 50) + 1, $student);
                }

                $model->students = $students->toArray();
            }
        }

        return $model;
    }
}