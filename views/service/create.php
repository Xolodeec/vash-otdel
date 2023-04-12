<?php

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = "Добавить товар";

$this->params['breadcrumbs'][] = $this->title;

?>

    <article class="profile-form-block">
        <header class="mb-3">
            <h4>Добавление товара</h4>
            <p>Заполните все поля</p>
        </header>
        <?php $form = ActiveForm::begin([
            'id' => 'create-product-form',
            'fieldConfig' => [
                'enableClientValidation' => false,
                'template' => "{input}{label}",
            ],
        ]) ?>

        <?= $form->field($model, 'name', ['options' => ['class' => 'form-floating mb-3']])->textInput(); ?>
        <?= $form->field($model, 'description', ['options' => ['class' => 'form-floating mb-3']])->textarea(); ?>
        <?= $form->field($model, 'price', ['options' => ['class' => 'form-floating mb-3']])->textInput(); ?>

        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>

        <?php $form::end() ?>
    </article>

