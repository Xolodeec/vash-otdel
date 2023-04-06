<?php

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = "Мой профиль";

$this->params['breadcrumbs'][] = $this->title;

?>


<article class="profile-form-block">
    <header>
        <h4>Общая информация</h4>
        <p>Краткая информация о вас</p>
    </header>
    <ul class="company-info">
        <li>Название компании: <?= Yii::$app->user->identity->title ?></li>
        <li>Номер телефона: <?= Yii::$app->user->identity->phone ?></li>
        <li>Реферальная ссылка: <?= Yii::$app->user->identity->referralLink ?></li>
    </ul>
</article>


<article class="profile-form-block">
    <header>
        <h4>Реквизиты компании</h4>
        <p>Заполните реквизиты компании</p>
    </header>

    <?php $form = ActiveForm::begin([
        'id' => 'requisite-form',
        'action' => '/profile/requisite',
        'fieldConfig' => [
            'enableClientValidation' => false,
            'template' => "{input}{label}",
        ],
    ]) ?>

    <?= $form->field($model, 'id')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'inn', ['options' => ['class' => 'form-floating mb-3 w-25']])->textInput(); ?>
    <?= $form->field($model, 'ogrn', ['options' => ['class' => 'form-floating mb-3 w-25']])->textInput(); ?>
    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>

    <?php $form::end() ?>
</article>

<article class="profile-form-block">
    <header>
        <h4>Банковские реквизиты</h4>
        <p>Заполните платежные реквизиты компании</p>
    </header>

    <?php $form = ActiveForm::begin([
        'id' => 'bank-details-form',
        'action' => '/profile/bank-detail',
        'fieldConfig' => [
            'enableClientValidation' => false,
            'template' => "{input}{label}",
        ],
    ]) ?>

    <?= $form->field($model->bankDetails, 'id')->hiddenInput()->label(false) ?>
    <?= $form->field($model->bankDetails, 'entityId')->hiddenInput(['value' => $model->id])->label(false) ?>

    <?= $form->field($model->bankDetails, 'title', ['options' => ['class' => 'form-floating mb-3 w-25']])->textInput(); ?>
    <?= $form->field($model->bankDetails, 'bik', ['options' => ['class' => 'form-floating mb-3 w-25']])->textInput(); ?>
    <?= $form->field($model->bankDetails, 'accNum', ['options' => ['class' => 'form-floating mb-3 w-25']])->textInput(); ?>
    <?= $form->field($model->bankDetails, 'corAccNum', ['options' => ['class' => 'form-floating mb-3 w-25']])->textInput(); ?>

    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>

    <?php $form::end() ?>
</article>
