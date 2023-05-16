<?php

use app\models\formWizard\FormWizard;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\web\JsExpression;

$this->title = "Оформление заявки на рассрочку";

?>

<div class="wrapper-form shadow-sm rounded mb-4">
    <h4 class="mb-4 text-center text-uppercase"><?= $this->title ?></h4>
    <?php echo FormWizard::widget([
        'formOptions'=>[
            'enableClientValidation'=> false,
            'enableAjaxValidation'=> true,
        ],
        'forceBsVersion' => 5,
        'toolbarPosition' => 'bottom',
        'labelNext' => 'Вперед',
        'labelPrev' => 'Назад',
        'labelFinish' => 'Отправить',
        'steps'=>[
            [
                'model' => $model,
                'title' => 'Шаг 0',
                'description'=> false,
                'formInfoText' => false,
                'fieldConfig' =>  [
                    'productId' => [
                        'template' => '{input}{label}',
                        'options' => [
                            'type' => 'dropdown',
                            'itemsList' => \yii\helpers\ArrayHelper::map($model->getProducts(), 'id', 'name'),
                            'prompt' => 'Выбрать товар',
                        ],
                    ],
                    'priceProduct' => [
                        'template' => '{input}{label}',
                    ],
                    'countMonthInstallment' => [
                        'template' => '{input}{label}',
                    ],
                    'codeWord' => [
                        'template' => '{input}{label}',
                    ],
                    'only' => ['productId', 'priceProduct', 'countMonthInstallment', 'codeWord'],
                ],
            ],
            [
                'model' => $model,
                'title' => 'Шаг 1',
                'description'=>'Add your shoots',
                'formInfoText' => false,
                'fieldConfig' =>  [
                    'lastName' => [
                        'template' => '{input}{label}',
                    ],
                    'name' => [
                        'template' => '{input}{label}',
                    ],
                    'secondName' => [
                        'template' => '{input}{label}',
                    ],
                    'education' => [
                        'template' => '{input}{label}',
                        'options' => [
                            'type' => 'dropdown',
                            'itemsList' => \yii\helpers\ArrayHelper::map($model->getTypeEducation(), 'ID', 'VALUE'),
                            'prompt' => 'Выбери',
                        ],
                    ],
                    'phone' => [
                        'widget' => \yii\widgets\MaskedInput::class,
                        'options' => [
                            'mask' => '+7 (999) 999 99 99',
                        ],
                        'template' => '{input}{label}',
                    ],
                    'email' => [
                        'template' => '{input}{label}',
                    ],
                    'only' => ['lastName', 'name', 'secondName', 'education', 'phone', 'email'],
                ],
            ],
            [
                'model' => $model,
                'title' =>'Шаг 2',
                'description' => 'Add your shoots',
                'formInfoText' => false,
                'fieldConfig' => [
                    'isChangeLastName' => [
                        'template' => '{input}{label}',
                        'options' => [
                            'type' => 'dropdown',
                            'itemsList' => ['Нет', 'Да'],
                            'prompt' => 'Выбери',
                        ],
                    ],
                    'previousLastName' => [
                        'template' => '{input}{label}',
                        'containerOptions'=> [
                            'class'=>'form-group'
                        ],
                    ],
                    'isMarried' => [
                        'template' => '{input}{label}',
                        'options' => [
                            'type' => 'dropdown',
                            'itemsList' => ['Нет', 'Да'],
                            'prompt' => 'Выбери',
                        ],
                    ],
                    'fullNamePartner' => [
                        'template' => '{input}{label}',
                    ],
                    'birthdayPartner' => [
                        'widget' => \kartik\date\DatePicker::class,
                        'options' => [
                            'language' => 'ru',
                        ],
                        'template' => '{label}{input}',
                    ],
                    'fullNameContactPerson' => [
                        'template' => '{input}{label}',
                    ],
                    'phoneContactPerson' => [
                        'widget' => \yii\widgets\MaskedInput::class,
                        'options' => [
                            'mask' => '+7 (999) 999 99 99',
                        ],
                        'template' => '{input}{label}',
                    ],
                    'only' => ['isChangeLastName', 'previousLastName', 'isMarried', 'fullNamePartner', 'birthdayPartner', 'fullNameContactPerson', 'phoneContactPerson'],
                ],
            ],
            [
                'model' => $model,
                'title' => 'Шаг 3',
                'description' => 'Add your shoots',
                'formInfoText' => false,
                'fieldConfig' => [
                    'registrationCity' => [
                        'template' => '{input}{label}',
                    ],
                    'registrationStreet' => [
                        'template' => '{input}{label}',
                    ],
                    'registrationBuild' => [
                        'template' => '{input}{label}',
                    ],
                    'registrationRoom' => [
                        'template' => '{input}{label}',
                    ],
                    'isRegistrationDataCompare' => [
                        'template' => '{input}{label}',
                        'options' => [
                            'type' => 'dropdown',
                            'itemsList' => ['Нет', 'Да'],
                            'prompt' => 'Выбери',
                        ],
                    ],
                    'residentialCity' => [
                        'template' => '{input}{label}',
                    ],
                    'residentialStreet' => [
                        'template' => '{input}{label}',
                    ],
                    'residentialBuild' => [
                        'template' => '{input}{label}',
                    ],
                    'residentialRoom' => [
                        'template' => '{input}{label}',
                    ],
                    'only' => ['registrationCity', 'registrationStreet', 'registrationBuild', 'registrationRoom', 'isRegistrationDataCompare', 'residentialCity', 'residentialStreet', 'residentialBuild', 'residentialRoom'],
                ],
            ],
            [
                'model' => $model,
                'title' => 'Шаг 4',
                'description' => 'Add your shoots',
                'formInfoText' => false,
                'fieldConfig' => [
                    'workNameCompany' => [
                        'template' => '{input}{label}',
                    ],
                    'workPhoneCompany' => [
                        'widget' => \yii\widgets\MaskedInput::class,
                        'options' => [
                            'mask' => '+7 (999) 999 99 99',
                        ],
                        'template' => '{input}{label}',
                    ],
                    'workCity' => [
                        'template' => '{input}{label}',
                    ],
                    'workStreet' => [
                        'template' => '{input}{label}',
                    ],
                    'workBuild' => [
                        'template' => '{input}{label}',
                    ],
                    'workPosition' => [
                        'template' => '{input}{label}',
                    ],
                    'amountMonthLastWork' => [
                        'template' => '{input}{label}',
                    ],
                    'salary' => [
                        'template' => '{input}{label}',
                    ],
                    'only' => ['workNameCompany', 'workPhoneCompany', 'workCity', 'workStreet', 'workBuild', 'workPosition', 'amountMonthLastWork', 'salary'],
                ],
            ],
        ]
    ]);
    ?>
</div>

<?php
    $this->registerJs(
            "
                $('#installmentform-ischangelastname').on('change', function(){
                
                    if($(this).val() == 1)
                    {
                        $('.field-installmentform-previouslastname').slideDown();
                    }
                    else
                    {
                        $('.field-installmentform-previouslastname').slideUp();
                    }
                });
                    
                $('#installmentform-ismarried').on('change', function(){
                
                    if($(this).val() == 1)
                    {
                        $('.field-installmentform-fullnamepartner, .field-installmentform-fullnamecontactperson, .field-installmentform-birthdaypartner,  .field-installmentform-phonecontactperson').slideDown();
                    }
                    else
                    {
                        $('.field-installmentform-fullnamepartner, .field-installmentform-fullnamecontactperson, .field-installmentform-birthdaypartner, .field-installmentform-phonecontactperson').slideUp();
                    }
                    
                    console.log($(this).val());
                });
                   
                $('#installmentform-isregistrationdatacompare').on('change', function(){
                
                    if($(this).val() == 0)
                    {
                        $('.field-installmentform-residentialcity, .field-installmentform-residentialstreet, .field-installmentform-residentialbuild, .field-installmentform-residentialroom').slideDown();
                    }
                    else
                    {
                        $('.field-installmentform-residentialcity, .field-installmentform-residentialstreet, .field-installmentform-residentialbuild, .field-installmentform-residentialroom').slideUp();
                    }
                    
                    console.log($(this).val());
                });
                   
                if($('#installmentform-ischangelastname').val() != 1)
                {
                    $('.field-installmentform-previouslastname').slideUp();
                }
                
                if($('#installmentform-ismarried').val() != 1)
                {
                    $('.field-installmentform-fullnamepartner, .field-installmentform-birthdaypartner, .field-installmentform-fullnamecontactperson, .field-installmentform-phonecontactperson').slideUp();
                }
                
                if($('#installmentform-isregistrationdatacompare').val() == 1)
                {
                    $('.field-installmentform-residentialcity, .field-installmentform-residentialstreet, .field-installmentform-residentialbuild, .field-installmentform-residentialroom').slideUp();
                }
                
                $('#installmentform-productid').on('change', function(){
                    if($(this).val() > 0)
                    {
                        setProductPrice($(this).val(), '#installmentform-priceproduct');
                    }
                });
            "
    );
?>


