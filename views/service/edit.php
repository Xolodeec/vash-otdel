<?php

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = "Изменить товар";

$this->params['breadcrumbs'][] = $this->title;

?>

<article class="profile-form-block">
    <header class="mb-3">
        <h4>Изменение товара</h4>
        <p>Измените данные товара</p>
    </header>
    <?php $form = ActiveForm::begin([
        'id' => 'create-product-form',
        'fieldConfig' => [
            'enableClientValidation' => false,
            'template' => "{input}{label}",
        ],
    ]) ?>

    <?= $form->field($model, 'name', ['options' => ['class' => 'form-floating mb-3 w-25']])->textInput(); ?>
    <?= $form->field($model, 'description', ['options' => ['class' => 'form-floating mb-3 w-25']])->textarea(); ?>
    <?= $form->field($model, 'price', ['options' => ['class' => 'form-floating mb-3 w-25']])->textInput(); ?>

    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>

    <?php $form::end() ?>
</article>