<?php

namespace app\models\student;

use app\models\bitrix\Bitrix;
use Tightenco\Collect\Support\Collection;
use yii\base\Model;

class StudentForm extends Model
{
    public $name;
    public $lastName;
    public $page;
    public $amountStudent;
    public $students;

    public function rules()
    {
        return [
            [['page', 'amountStudent'], 'number'],
            [['amountStudent'], 'default', 'value' => 0],
            [['students'], 'default', 'value' => []],
            [['name', 'lastName'], 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Имя',
            'lastName' => 'Фамилия',
        ];
    }

    public static function generate($companyId, $params = [])
    {
        $params = collect($params);

        $model = new static();
        $model->page = $params->has('page') ? $params->get('page') - 1 : 0;

        $paramsRequest = [
            'order' => ['ID' => 'DESC'],
            'filter' => ['UF_CRM_1680707854' => $companyId],
            'select' => collect(Student::mapFields())->keys()->toArray(),
            'start' => $model->page * 50,
        ];

        if($params->has('StudentForm') && $model->load($params->toArray()))
        {
            if(!empty($model->name)) $paramsRequest['filter']['%NAME'] = $model->name;
            if(!empty($model->lastName)) $paramsRequest['filter']['%LAST_NAME'] = $model->lastName;
        }

        $bitrix = new Bitrix;

        $response = $bitrix->request('crm.contact.list', $paramsRequest);

        if($model->validate() && $response['total'] > 0)
        {
            $model->amountStudent = $response['total'];
            $model->students = Student::multipleCollect(Student::class, $response['result']);

            if(!empty($model->students))
            {
                $students = new Collection();

                foreach ($model->students as $index => $student)
                {
                    $students->put($index + ($model->page * 50) + 1, $student);
                }

                $model->students = $students->toArray();
            }
        }

        return $model;
    }
}