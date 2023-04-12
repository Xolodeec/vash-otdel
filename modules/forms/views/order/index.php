<?php

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = "Заявка";

?>


<div class="wrapper-form shadow-sm rounded mb-4">
    <h4 class="mb-4 text-center text-uppercase"><?= $this->title ?></h4>
    <?php $form = ActiveForm::begin([
        'id' => 'order-form',
        'fieldConfig' => [
            'enableClientValidation' => false,
            'template' => "{input}{label}",
        ],
    ]) ?>

    <?= $form->field($model, 'lastName', ['options' => ['class' => 'form-floating mb-3']])->textInput(); ?>
    <?= $form->field($model, 'name', ['options' => ['class' => 'form-floating mb-3']])->textInput(); ?>
    <?= $form->field($model, 'secondName', ['options' => ['class' => 'form-floating mb-3']])->textInput(); ?>

    <?= $form->field($model, 'phone', ['options' => ['class' => 'form-floating mb-3']])->widget(\yii\widgets\MaskedInput::class, [
        'mask' => '+7 (999) 999 99 99',
    ]); ?>
    <?= $form->field($model, 'productId', ['options' => ['class' => 'form-floating mb-3']])->dropDownList(\yii\helpers\ArrayHelper::map($model->getProducts(), 'id', 'name'), ['prompt' => 'Выбрать товар',]); ?>
    <?= $form->field($model, 'isAgree', ['options' => ['class' => 'mb-3']])->checkbox()->label("Я согласен на <a href='". $model->getLinkAgree() . "' target='_blank'>обработку персональных данных</a>"); ?>
    <?= Html::submitButton('Отправить', ['class' => 'btn btn-success w-100']) ?>

    <?php $form::end() ?>
</div>

