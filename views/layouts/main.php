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

<header id="header">
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <div class="logo">
                    <img src="/src/logo.svg" class="img-fluid">
                </div>
            </div>
            <div class="col-auto d-flex align-items-center">
                <button class="navbar-toggler first-button" type="button">
                    <div class="animated-icon1"><span></span><span></span><span></span></div>
                </button>
            </div>
        </div>
    </div>
    <div class="collapse navbar-collapse">
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
                        <a href="<?= \yii\helpers\Url::to('/main/students') ?>"> Клиенты</a>
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
                        <i class="fa-solid fa-sheet-plastic"></i>
                    </div>
                    <div class="col">
                        <div class="dropdown">
                            <a href="javascript:void(0);" class="dropbtn-report">Мои отчёты</a>
                            <div class="wrapper-report">
                                <ul id="list">
                                    <li><a href="<?= \yii\helpers\Url::to('/report/installment') ?>" >Рассрочка</a></li>
                                    <li><a href="<?= \yii\helpers\Url::to('/report/acquiring') ?>" >Эквайринг</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="row g-0">
                    <div class="col-1" style="margin-right: 20px">
                        <i class="fa-solid fa-address-card"></i>
                    </div>
                    <div class="col">
                        <div class="dropdown">
                            <a href="javascript:void(0);" class="dropbtn-profile">Профиль</a>
                            <div class="wrapper-profile">
                                <ul id="list">
                                    <li><a href="<?= \yii\helpers\Url::to('/profile') ?>" >Информация</a></li>
                                    <li><a href="<?= \yii\helpers\Url::to('/profile/settings') ?>" >Настройки</a></li>
                                </ul>
                            </div>
                        </div>
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
    </div>
</header>

<main id="main">
    <div class="inner">
        <div class="sidebar left">
            <div class="logo">
                <img src="/src/logo.svg" class="img-fluid">
            </div>
            <nav class="navigation">
                <ul>
                    <li class="row g-0">
                        <div class="col-1" style="margin-right: 20px">
                            <i class="fa-solid fa-house col-1"></i>
                        </div>
                        <div class="col">
                            <div class="dropdown">
                                <a href="javascript:void(0);" class="dropbtn-order">Заказы</a>
                                <div class="wrapper-order">
                                    <ul id="list">
                                        <li><a href="<?= \yii\helpers\Url::to('/order/installment') ?>" >Рассрочка</a></li>
                                        <li><a href="<?= \yii\helpers\Url::to('/order/acquiring') ?>" >Эквайринг</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="row g-0">
                        <div class="col-1" style="margin-right: 20px">
                            <i class="fa-solid fa-graduation-cap"></i>
                        </div>
                        <div class="col">
                            <a href="<?= \yii\helpers\Url::to('/main/students') ?>"> Клиенты</a>
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
                            <i class="fa-solid fa-sheet-plastic"></i>
                        </div>
                        <div class="col">
                            <div class="dropdown">
                                <a href="javascript:void(0);" class="dropbtn-report">Мои отчёты</a>
                                <div class="wrapper-report">
                                    <ul id="list">
                                        <li><a href="<?= \yii\helpers\Url::to('/report/installment') ?>" >Рассрочка</a></li>
                                        <li><a href="<?= \yii\helpers\Url::to('/report/acquiring') ?>" >Эквайринг</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="row g-0">
                        <div class="col-1" style="margin-right: 20px">
                            <i class="fa-solid fa-address-card"></i>
                        </div>
                        <div class="col">
                            <div class="dropdown">
                                <a href="javascript:void(0);" class="dropbtn-profile">Профиль</a>
                                <div class="wrapper-profile">
                                    <ul id="list">
                                        <li><a href="<?= \yii\helpers\Url::to('/profile') ?>" >Информация</a></li>
                                        <li><a href="<?= \yii\helpers\Url::to('/profile/settings') ?>" >Настройки</a></li>
                                    </ul>
                                </div>
                            </div>
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
