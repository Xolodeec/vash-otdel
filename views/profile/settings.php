<?php

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\helpers\ArrayHelper;

$this->title = "Настройки профиля";

$this->params['breadcrumbs'][] = $this->title;

?>

<article class="profile-form-block">
    <header>
        <h4>Отчёт</h4>
        <p>Выберите периодичность отчёта</p>
    </header>

    <?php $form = ActiveForm::begin([
        'id' => 'settings',
        'fieldConfig' => [
            'enableClientValidation' => false,
            'template' => "{input}{label}",
        ],
    ]) ?>

    <?= $form->field($model, 'id')->hiddenInput()->label(false) ?>
    <?= $form->field($model, 'reportPeriodicity', ['options' => ['class' => 'form-floating mb-3']])->dropDownList($model->getListPeriodicity(), ['prompt' => 'Выберите переодичность']) ?>

    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>

    <?php $form::end() ?>
</article>
