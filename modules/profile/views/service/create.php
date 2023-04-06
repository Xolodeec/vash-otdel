<?php

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = "Добавить услугу";

?>

<div class="toolbar">
    <?= Html::a('Назад', '/profile/service', ['class' => 'btn btn-primary']) ?>
</div>

<?php $form = ActiveForm::begin([
    'id' => 'create-product-form',
    'fieldConfig' => [
        'enableClientValidation' => false,
    ],
]) ?>

<?= $form->field($model, 'name')->textInput(); ?>
<?= $form->field($model, 'description')->textarea(); ?>
<?= $form->field($model, 'price')->textInput(); ?>

<?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>

<?php $form::end() ?>