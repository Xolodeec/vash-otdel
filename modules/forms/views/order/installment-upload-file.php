<?php

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = "Загрузка файлов";

?>


<div class="wrapper-form shadow-sm rounded mb-4">
    <h4 class="mb-4 text-center text-uppercase"><?= $this->title ?></h4>
    <?php $form = ActiveForm::begin([
        'id' => 'order-form',
        'fieldConfig' => [
            'enableClientValidation' => false,
            'template' => "{label}{input}",
        ],
    ]) ?>

    <?= $form->field($model, 'passportPhoto1')->fileInput(); ?>
    <?= $form->field($model, 'passportPhoto2')->fileInput(); ?>
    <?= $form->field($model, 'passportPhoto3')->fileInput(); ?>
    <?= $form->field($model, 'passportPhoto4')->fileInput(); ?>

    <?= Html::submitButton('Отправить', ['class' => 'btn btn-success w-100']) ?>

    <?php $form::end() ?>
</div>


