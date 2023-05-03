<?php

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = "Мои товары";

$this->params['breadcrumbs'][] = $this->title;

?>

<div class="toolbar mt-3 mb-3">
    <?= Html::a('Добавить', '/service/create', ['class' => 'btn btn-success mb-2']) ?>
</div>

<div class="wrapper-block mt-3">
    <table class="default-table">
        <thead>
        <tr>
            <th class="text-center column-small">#</th>
            <th>Название</th>
            <th>Цена</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <?php if(!empty($products)) : ?>
            <?php foreach ($products as $row => $product) : ?>
                <tr>
                    <td><?= $row + 1?></td>
                    <td><?= $product->name ?></td>
                    <td><?= $product->price ?></td>
                    <td class="text-center column-btn">
                        <?= Html::a('<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16">
  <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"/>
</svg>', \yii\helpers\Url::to(['/service/edit', 'id' => $product->id])) ?>

                        <?= Html::a('<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
  <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z"/>
</svg>', \yii\helpers\Url::to(['/service/delete', 'id' => $product->id])) ?>

                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="3" class="text-center">Нет данных</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
