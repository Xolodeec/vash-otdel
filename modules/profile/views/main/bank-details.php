<?php

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = "Банковские реквизиты";

?>

<?php $form = ActiveForm::begin([
    'id' => 'bank-details-form',
    'fieldConfig' => [
        'enableClientValidation' => false,
    ],
]) ?>

<?= $form->field($model->bankDetails, 'id')->hiddenInput()->label(false) ?>
<?= $form->field($model->bankDetails, 'entityId')->hiddenInput(['value' => $model->id])->label(false) ?>

<?= $form->field($model->bankDetails, 'title')->textInput(); ?>
<?= $form->field($model->bankDetails, 'bik')->textInput(); ?>
<?= $form->field($model->bankDetails, 'accNum')->textInput(); ?>
<?= $form->field($model->bankDetails, 'corAccNum')->textInput(); ?>

<?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>

<?php $form::end() ?>
