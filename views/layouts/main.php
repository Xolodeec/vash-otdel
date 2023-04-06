<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <script src="https://kit.fontawesome.com/78d57075c0.js" crossorigin="anonymous"></script>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<main id="main">
    <div class="inner">
        <div class="sidebar left">
            <nav class="navigation">
                <ul>
                    <li class="row g-0">
                        <div class="col-1" style="margin-right: 20px">
                            <i class="fa-solid fa-house col-1"></i>
                        </div>
                        <div class="col">
                            <a href="<?= \yii\helpers\Url::to('/') ?>">Главная</a>
                        </div>
                    </li>
                    <li class="row g-0">
                        <div class="col-1" style="margin-right: 20px">
                            <i class="fa-solid fa-graduation-cap"></i>
                        </div>
                        <div class="col">
                            <a href="<?= \yii\helpers\Url::to('/main/students') ?>"> Студенты</a>
                        </div>
                    </li>
                    <li class="row g-0">
                        <div class="col-1" style="margin-right: 20px">
                            <i class="fa-solid fa-database"></i>
                        </div>
                        <div class="col">
                            <a href="<?= \yii\helpers\Url::to('/service') ?>"> Мои товары</a>
                        </div>
                    </li>
                    <li class="row g-0">
                        <div class="col-1" style="margin-right: 20px">
                            <i class="fa-solid fa-address-card"></i>
                        </div>
                        <div class="col">
                            <a href="<?= \yii\helpers\Url::to('/profile') ?>">Профиль</a>
                        </div>
                    </li>
                    <li class="row g-0">
                        <div class="col-1" style="margin-right: 20px">
                            <i class="fa-solid fa-right-from-bracket"></i>
                        </div>
                        <div class="col">
                            <a href="<?= \yii\helpers\Url::to('/auth/main/logout') ?>"> Выход</a>
                        </div>
                    </li>
                </ul>
            </nav>
            <div class="user-block">
                <?= Yii::$app->user->identity->title ?>
            </div>
        </div>
        <div class="content">
            <?php if (!empty($this->params['breadcrumbs'])): ?>
                <?= Breadcrumbs::widget([
                        'homeLink' => ['label' => 'Главная', 'url' => '/'],
                        'links' => $this->params['breadcrumbs'],
                        'itemTemplate' => "<li>{link}</li><li>/</li> \n",
                ]) ?>
            <?php endif ?>
            <?= Alert::widget() ?>
            <?= $content ?>
        </div>
    </div>
</main>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
