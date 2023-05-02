<?php

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = "Отчёт по рассрочке";

$this->params['breadcrumbs'][] = $this->title;

?>

<div class="grey-wrapper">
    <?php $form = ActiveForm::begin([
        'id' => 'students-form',
        'method' => 'GET',
        'action' => \yii\helpers\Url::to('installment'),
        'fieldConfig' => [
            'enableClientValidation' => false,
        ],
    ]) ?>
    <div class="row">
        <div class="col-auto">
            <?= $form->field($model, 'dateFrom', ['options' => ['class' => 'mb-0']])->textInput(['type' => 'date']); ?>
        </div>
        <div class="col-auto">
            <?= $form->field($model, 'dateTo', ['options' => ['class' => 'mb-0']])->textInput(['type' => 'date']); ?>
        </div>
        <div class="col-auto d-flex align-items-end">
            <?= Html::submitButton('Найти', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
    <?php $form::end(); ?>
</div>

<div class="wrapper-block mt-3">
    <table class="default-table">
        <thead>
        <tr>
            <th class="text-center column-small">#</th>
            <th>ФИО</th>
            <th>Сумма авторизованных договоров</th>
            <th>Авторизовано договоров</th>
            <th>Отказов Клиента</th>
            <th>Отказов Банка</th>
        </tr>
        </thead>
        <tbody>
        <?php if(!empty($students)) : ?>
            <?php foreach($students as $index => $student) : ?>
                <tr>
                    <td class="text-center"><span class="bg-blue"><?= $index ?><span></td>
                    <td><?= $student->lastName . ' ' . $student->name . ' ' . $student->secondName ?></td>
                    <td><?= $student->wonDealsSum ?></td>
                    <td><?= $student->countWonDeal ?></td>
                    <td><?= $student->countApologyDeal ?></td>
                    <td><?= $student->countLoseDeal ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td class="text-center" colspan="4">Ничего не найдено</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>

