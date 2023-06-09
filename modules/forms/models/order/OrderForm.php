<?php

namespace app\modules\forms\models\order;

use app\models\bitrix\Bitrix;
use app\models\bitrix\crm\Company;
use app\models\bitrix\crm\Deal;
use app\models\bitrix\crm\Product;
use app\models\student\Student;
use Tightenco\Collect\Support\Collection;
use yii\base\Model;

class OrderForm extends Model
{
    public $name;
    public $secondName;
    public $lastName;
    public $productId;
    public $priceProduct;
    public $phone;
    public $isAgree;

    protected $company;
    protected $products;

    public function rules()
    {
        return [
            [['name', 'secondName', 'lastName'], 'string'],
            [['name', 'lastName', 'phone', 'productId', 'priceProduct', 'secondName', /*'isAgree'*/], 'required'],
            ['isAgree', 'compare', 'compareValue'=> 1, 'message' => ""],
            [['productId'], 'number'],
            //[['isAgree'], 'boolean'],
            [['phone'], 'filter', 'filter' => function($item){
                return preg_replace('/[^0-9+]/', '', $item);
            }],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Имя',
            'secondName' => 'Отчество',
            'lastName' => 'Фамилия',
            'phone' => 'Телефон',
            'productId' => 'Товар',
            'isAgree' => 'Я согласен на обработку персональных данных',
            'priceProduct' => 'Цена товара',
        ];
    }

    public static function instanceByToken($token)
    {
        $bitrix = new Bitrix();
        $commands = new Collection();

        $commands->put('get_company', $bitrix->buildCommand('crm.company.list', [
            'filter' => [
                '=UF_CRM_1680701873800' => $token
            ],
            'select' => collect(Company::mapFields())->keys()->toArray()
        ]));

        $commands->put('get_products', $bitrix->buildCommand('crm.product.list', [
            'filter' => ['PROPERTY_64' => '$result[get_company][0][ID]'],
            'start' => -1,
            'select' => collect(Product::mapFields())->keys()->toArray(),
        ]));

        ['result' => ['result' => $result]] = $bitrix->batchRequest($commands->toArray());

        if(!empty(collect($result)->get('get_company')))
        {
            $model = new static();

            $companyData = collect($result)->get('get_company')[0];
            $productData = collect($result)->get('get_products');

            $model->company = new Company();

            if($model->company::collect($model->company, $companyData))
            {
                $model->products = Product::multipleCollect(Product::class, $productData);
            }

            return $model;
        }

        return false;
    }

    public function getProducts()
    {
        return $this->products;
    }

    public function collectDeal()
    {
        $deal = new Deal();
        $deal->companyId = $this->company->id;

        return $deal;
    }

    public function collectContact()
    {
        $student = new Student();
        $student->name = $this->name;
        $student->lastName = $this->lastName;
        $student->secondName = $this->secondName;
        $student->assignedByCompany = $this->company->id;
        $student->phone[] = ['VALUE' => $this->phone];

        return $student;
    }

    public function save()
    {
        $bitrix = new Bitrix;
        $commands = new Collection();

        $student = Student::findByPhone($this->phone);
        $deal = $this->collectDeal();

        if($student)
        {
            $deal->contactId = $student->id;
        }
        else
        {
            $student = $this->collectContact();
            $deal->contactId = '$result[contact_add]';

            $commands->put('contact_add', $bitrix->buildCommand('crm.contact.add', ['fields' => $student::getParamsField($student)]));
        }

        $commands->put('deal_add', $bitrix->buildCommand('crm.deal.add', ['fields' => $deal::getParamsField($deal)]));
        $commands->put('product_add', $bitrix->buildCommand('crm.deal.productrows.set', [
            'id' => '$result[deal_add]',
            'rows' => [
                ['PRODUCT_ID' => $this->getSelectedProduct()->id, 'PRICE' => $this->getSelectedProduct()->price],
            ]
        ]));

        return $bitrix->batchRequest($commands->toArray());
    }

    public function getLinkAgree()
    {
        return \Yii::$app->request->hostInfo . '/src/politica.pdf';
    }

    public function getSelectedProduct()
    {
        $productId = $this->productId;

        return collect($this->products)->filter(function ($item) use($productId){
            return $item->id == $productId;
        })->values()->get(0);
    }
}