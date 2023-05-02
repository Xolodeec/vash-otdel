<?php

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = "Мои отчеты";

$this->params['breadcrumbs'][] = $this->title;

?>

<div class="grey-wrapper">
    <?php $form = ActiveForm::begin([
        'id' => 'students-form',
        'method' => 'GET',
        'action' => \yii\helpers\Url::to('/report-app/main/acquiring'),
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
        <div class="col-auto">
            <div class="select-company-bx24 form-control" style="margin-top: 30px">
                <?php if(!empty($model->companyName)) : ?>
                    <div onclick="BX24.selectCRM({entityType: ['company'], multiple: false,}, function(){
                                selectCompanyBx24(arguments);
                            })" class="unselected-co-b24" style="display: none">
                        <i class="fa-sharp fa-solid fa-plus"></i>Выбрать компанию
                    </div>
                    <div onclick="unselectCompanyBx24()" class="selected-co-bx24 w-auto h-100 d-flex align-items-center">
                        <?= $model->companyName ?><i class="fa-solid fa-xmark"></i>
                    </div>
                <?php else: ?>
                    <div onclick="BX24.selectCRM({entityType: ['company'],multiple: false,}, function(){
                                selectCompanyBx24(arguments);
                            })" class="unselected-co-b24 w-auto h-100 d-flex align-items-center">
                        <i class="fa-sharp fa-solid fa-plus"></i>Выбрать компанию
                    </div>
                    <div onclick="unselectCompanyBx24()" class="selected-co-bx24" style="display: none">
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <?= Html::activeHiddenInput($model, 'companyId', ['class' => 'company-id']) ?>
        <?= Html::activeHiddenInput($model, 'companyName') ?>
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
            <th>Компания</th>
            <th>Сумма авторизованных договоров</th>
            <th>Авторизовано договоров</th>
            <th>Отказов Клиента</th>
        </tr>
        </thead>
        <tbody>
        <?php if(!empty($schools)) : ?>
            <tr>
                <td></td>
                <td>Итого:</td>
                <td><?= $model->wonDealsSum ?></td>
                <td><?= $model->countWonDeal ?></td>
                <td><?= $model->countLoseDeal ?></td>
            </tr>
            <?php foreach($schools as $index => $school) : ?>
                <tr>
                    <td class="text-center"><span class="bg-blue"><?= $index ?><span></td>
                    <td><a class="app-link" href="javascript::void()" onclick="BX24.openPath('/crm/company/details/<?=$school->id?>/')"> <?= $school->title ?></a></td>
                    <td><?= $school->wonDealsSum ?></td>
                    <td><?= $school->countWonDeal ?></td>
                    <td><?= $school->countLoseDeal ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td class="text-center" colspan="5">Ничего не найдено</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
