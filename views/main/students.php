<?php

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = "Клиенты";

$this->params['breadcrumbs'][] = $this->title;

?>


<div class="grey-wrapper">
    <?php $form = ActiveForm::begin([
        'id' => 'students-form',
        'method' => 'GET',
        'action' => \yii\helpers\Url::to('/students'),
        'fieldConfig' => [
            'enableClientValidation' => false,
        ],
    ]) ?>
    <div class="row">
        <div class="col-auto">
            <?= $form->field($model, 'lastName', ['options' => ['class' => 'mb-0']])->textInput(['placeholder' => $model->getAttributeLabel('lastName')]); ?>
        </div>
        <div class="col-auto">
            <?= $form->field($model, 'name', ['options' => ['class' => 'mb-0']])->textInput(['placeholder' => $model->getAttributeLabel('name')]); ?>
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
                <th>Фамилия</th>
                <th>Имя</th>
                <th>Отчество</th>
            </tr>
        </thead>
        <tbody>
        <?php if(!empty($students)) : ?>
        <?php foreach($students as $index => $student) : ?>
            <tr>
                <td class="text-center"><span class="bg-blue"><?= $index ?><span></td>
                <td><?= $student->lastName ?></td>
                <td><?= $student->name ?></td>
                <td><?= $student->secondName ?></td>
            </tr>
        <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td class="text-center" colspan="4">Ничего не найдено</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
    <?php if($pages->totalCount > 0) : ?>
    <footer>
        <?= \yii\bootstrap5\LinkPager::widget([
                'pagination' => $pages,
                'prevPageCssClass' => 'up-prev',
                'prevPageLabel' => 'Назад',
                'pageCssClass' => 'up-page',
                'nextPageCssClass' => 'up-next',
                'nextPageLabel' => 'Вперед',
                'options' => [
                    'class' => 'up-pagination',
                ],
                'linkOptions' => [
                     'class' => "",
                ],
        ]) ?>
    </footer>
    <?php endif; ?>
</div>

