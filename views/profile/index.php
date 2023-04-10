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

    <?php if($model->presetId == 1) : ?>
    <?= $form->field($model, 'directorName', ['options' => ['class' => 'form-floating mb-3']])->textInput(); ?>
    <?php endif; ?>

    <?= $form->field($model, 'inn', ['options' => ['class' => 'form-floating mb-3']])->textInput(); ?>
    <?= $form->field($model, 'ogrn', ['options' => ['class' => 'form-floating mb-3']])->textInput(); ?>
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

    <?= $form->field($model->bankDetails, 'title', ['options' => ['class' => 'form-floating mb-3']])->textInput(); ?>
    <?= $form->field($model->bankDetails, 'bik', ['options' => ['class' => 'form-floating mb-3']])->textInput(); ?>
    <?= $form->field($model->bankDetails, 'accNum', ['options' => ['class' => 'form-floating mb-3']])->textInput(); ?>
    <?= $form->field($model->bankDetails, 'corAccNum', ['options' => ['class' => 'form-floating mb-3']])->textInput(); ?>

    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>

    <?php $form::end() ?>
</article>

<article class="profile-form-block">
    <header>
        <h4>Фактический адрес</h4>
        <p>Укажите фактический адрес</p>
    </header>

    <?php $form = ActiveForm::begin([
        'id' => 'bank-details-form',
        'action' => '/profile/address',
        'fieldConfig' => [
            'enableClientValidation' => false,
            'template' => "{input}{label}",
        ],
    ]) ?>

    <?= $form->field($model->actualAddress, 'typeId')->hiddenInput()->label(false) ?>
    <?= $form->field($model->actualAddress, 'entityTypeId')->hiddenInput()->label(false) ?>
    <?= $form->field($model->actualAddress, 'entityId')->hiddenInput(['value' => $model->id])->label(false) ?>

    <?= $form->field($model->actualAddress, 'address1', ['options' => ['class' => 'form-floating mb-3']])->textInput(); ?>

    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>

    <?php $form::end() ?>
</article>

<article class="profile-form-block">
    <header>
        <h4>Юридический адрес</h4>
        <p>Укажите юридический адрес</p>
    </header>

    <?php $form = ActiveForm::begin([
        'id' => 'bank-details-form',
        'action' => '/profile/address',
        'fieldConfig' => [
            'enableClientValidation' => false,
            'template' => "{input}{label}",
        ],
    ]) ?>

    <?= $form->field($model->legalAddress, 'typeId')->hiddenInput()->label(false) ?>
    <?= $form->field($model->legalAddress, 'entityTypeId')->hiddenInput()->label(false) ?>
    <?= $form->field($model->legalAddress, 'entityId')->hiddenInput(['value' => $model->id])->label(false) ?>

    <?= $form->field($model->legalAddress, 'address1', ['options' => ['class' => 'form-floating mb-3']])->textInput(); ?>

    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>

    <?php $form::end() ?>
</article>
