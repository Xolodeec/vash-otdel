<?php

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = "Авторизация";

?>


<div class="wrapper-form shadow-sm rounded mb-4">
    <h4 class="mb-4 text-center text-uppercase">Авторизация</h4>
    <?php if( Yii::$app->session->hasFlash('success') ): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo Yii::$app->session->getFlash('success'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Закрыть"></button>
        </div>
    <?php endif;?>
    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'fieldConfig' => [
            'enableClientValidation' => false,
            //'template' => "<div class='row'><div class='col-3'>{label}</div><div class='col'>{input}</div></div>{error}",
            'template' => "{input}{label}",
        ],
    ]) ?>
    <?= $form->field($model, 'phone', ['options' => ['class' => 'form-floating mb-3']])->widget(\yii\widgets\MaskedInput::class, [
        'mask' => '+7 (999) 999 99 99',
    ]); ?>
    <?= $form->field($model, 'password', ['options' => ['class' => 'form-floating mb-3']])->passwordInput(); ?>
    <?= Html::submitButton('Войти', ['class' => 'btn btn-primary w-100']) ?>

    <?php $form::end() ?>
</div>

<div class="auth-toolbar text-center">
    <?= Html::a('Сбросить пароль', 'reset'); ?> | <?= Html::a('Регистрация', 'sign-up'); ?>
</div>

