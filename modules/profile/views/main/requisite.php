<?php

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = "Мои реквизиты";

?>

<?php $form = ActiveForm::begin([
    'id' => 'requisite-form',
    'fieldConfig' => [
        'enableClientValidation' => false,
    ],
]) ?>

<?= $form->field($model, 'id')->hiddenInput()->label(false) ?>

<?= $form->field($model, 'inn')->textInput(); ?>
<?= $form->field($model, 'ogrn')->textInput(); ?>
<?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>

<?php $form::end() ?>
