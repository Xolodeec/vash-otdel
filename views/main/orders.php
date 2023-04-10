<?php

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = "Заказы";

$this->params['breadcrumbs'][] = $this->title;

?>

<div class="wrapper-block mt-3">
    <table class="default-table">
        <thead>
        <tr>
            <th class="text-center column-small">#</th>
            <th>Название сделки</th>
            <th>Товар</th>
            <th>Статус</th>
            <th>Сумма</th>
        </tr>
        </thead>
        <tbody>
        <?php if(!empty($orders)) : ?>
        <?php foreach($orders as $index => $order) : ?>
            <tr>
                <td class="text-center"><span class="bg-blue"><?= $index ?><span></td>
                <td><?= $order->title ?></td>
                <td><?= $order->product->title ?></td>
                <td><?= $order->_stages[$order->stageId] ?></td>
                <td><?= $order->opportunity ?></td>
            </tr>
        <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td class="text-center" colspan="5">Ничего не найдено</td>
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

