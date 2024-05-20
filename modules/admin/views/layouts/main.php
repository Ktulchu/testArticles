<?php

/**
 * @var View $this
 * @var string $content
 */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\helpers\Url;
use yii\web\View;

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
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>
<header id="header" class="navbar navbar-static-top">
    <div class="navbar-header">
        <a type="button" id="button-menu" class="pull-left"><i class="fa fa-indent fa-lg"></i></a>
        <a href="<?= Url::to(['/admin']) ?>" class="navbar-brand">
            Панель администрирования
        </a>
    </div>
</header>
<nav id="column-left">
    <div id="profile">
        <div>
            <i class="bi bi-person-fill"></i>
        </div>
        <div>
            <h4><?= Yii::$app->user->identity->username; ?></h4>
            <small>Администратор</small>
        </div>
    </div>
    <?= Nav::widget([
        'options' => ['id' => 'menu', 'class' => 'navbar-nav'],
        'items' => [
            ['label' => 'Категории', 'url' => ['category/index']],
            ['label' => 'Авторы', 'url' => ['authors/index']],
            ['label' => 'Статьи', 'url' => ['articles/index']],
            ['label' => 'Пользователи', 'url' => ['user/index']],
        ]
    ]); ?>
</nav>
<div id="content">
    <div class="page-header">
        <div class="container-fluid">
            <?= Breadcrumbs::widget([
                'links' => $this->params['breadcrumbs'] ?? [],
            ]) ?>
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
    </div>
    <div class="container-fluid">
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
