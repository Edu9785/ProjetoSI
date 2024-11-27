<?php

/** @var \yii\web\View $this */
/** @var string $content */

use common\widgets\Alert;
use frontend\assets\AppAsset;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;
use yii\helpers\Url;

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <?php AppAsset::register($this); ?>
    <title><?= Html::encode($this->title) ?></title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">
    <?php $this->head() ?>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<header>
    <!-- Topbar Start -->
    <div class="container-fluid">
        <div class="row align-items-center bg-light py-3 px-xl-5 d-none d-lg-flex">
            <div class="col-lg-4">
                <?= Html::a(
                    '<span class="h1 text-uppercase text-primary bg-dark px-2">Nexel</span>
     <span class="h1 text-uppercase text-dark bg-primary px-2 ml-n1">Tools</span>',
                    ['site/index'],
                    ['class' => 'text-decoration-none']
                ) ?>
            </div>
            <div class="col-lg-4 col-6 text-left">
                <form action="">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Pesquisar">
                        <div class="input-group-append">
                            <span class="input-group-text bg-transparent text-primary">
                                <i class="fa fa-search"></i>
                            </span>
                        </div>
                    </div>
                </form>

            </div>
            <div class="col-lg-4 col-6 text-right">
                <div class="d-inline-flex align-items-center">
                    <div class="btn-group">
                        <?php if(Yii::$app->user->isGuest): ?>
                        <button type="button" class="btn btn-sm btn-light dropdown-toggle" data-toggle="dropdown">Conta  <i class="fas fa-user"></i></button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <?= Html::a('Login  <i class="fas fa-sign-in-alt"></i>', ['site/login'], ['class' => 'dropdown-item']) ?>
                                <?= Html::a('Registar  <i class="fas fa-user-plus"></i>', ['site/signup'], ['class' => 'dropdown-item']) ?>
                            </div>
                        <?php else: ?>
                            <button type="button" class="btn btn-sm btn-light dropdown-toggle" data-toggle="dropdown"><?= Yii::$app->user->identity->username ?>  <i class="fas fa-user"></i></button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <?= Html::a('Perfil  <i class="fas fa-user"></i>', ['profile/index'], ['class' => 'dropdown-item']) ?>
                                <?= Html::a('Logout  <i class="fas fa-sign-out-alt"></i>', ['site/logout'], [
                                    'class' => 'dropdown-item',
                                    'data' => [
                                        'method' => 'post',
                                        'confirm' => 'Tem certeza que deseja sair?',
                                    ],
                                ]) ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- Topbar End -->


    <!-- Navbar Start -->
    <div class="container-fluid bg-dark mb-30">
        <div class="row px-xl-5">
            <div class="col-lg-3 d-none d-lg-block">
                <a class="btn d-flex align-items-center justify-content-between bg-primary w-100" data-toggle="collapse" href="#navbar-vertical" style="height: 65px; padding: 0 30px;">
                    <h6 class="text-dark m-0"><i class="fa fa-bars mr-2"></i>Categorias</h6>
                    <i class="fa fa-angle-down text-dark"></i>
                </a>
                <nav class="collapse position-absolute navbar navbar-vertical navbar-light align-items-start p-0 bg-light" id="navbar-vertical" style="width: calc(100% - 30px); z-index: 999;">
                    <div class="navbar-nav w-100">
                        <?php $categorias = \common\models\Categoria::find()->all() ?>
                        <?php foreach ($categorias as $categoria): ?>
                        <a href="<?= Url::to(['categoria/view', 'id' => $categoria->id]) ?>" class="nav-item nav-link">
                            <?= Html::encode($categoria->tipo) ?>
                        </a>
                        <?php endforeach;?>

                    </div>
                </nav>
            </div>
            <div class="col-lg-9">
                <nav class="navbar navbar-expand-lg bg-dark navbar-dark py-3 py-lg-0 px-0">
                    <a href="" class="text-decoration-none d-block d-lg-none">
                        <span class="h1 text-uppercase text-dark bg-light px-2">Nexel</span>
                        <span class="h1 text-uppercase text-light bg-primary px-2 ml-n1">Tools</span>
                    </a>
                    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                        <div class="navbar-nav mr-auto py-0">
                            <?= Html::a('Home', ['site/index'], ['class' => 'nav-item nav-link active']) ?>
                            <a href="#" class="nav-item nav-link">MarketPlace</a>
                            <div class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Páginas <i class="fa fa-angle-down mt-1"></i></a>
                                <div class="dropdown-menu bg-primary rounded-0 border-0 m-0">
                                    <a href="#" class="dropdown-item">Carrinho</a>
                                    <a href="#" class="dropdown-item">Checkout</a>
                                </div>
                            </div>
                            <a href="#" class="nav-item nav-link">Suporte</a>
                        </div>
                        <div class="navbar-nav ml-auto py-0 d-none d-lg-block">
                            <a href="" class="btn px-0">
                                <i class="fas fa-heart text-primary"></i>
                                <span class="badge text-secondary border border-secondary rounded-circle" style="padding-bottom: 2px;">0</span>
                            </a>
                            <a href="" class="btn px-0 ml-3">
                                <i class="fas fa-shopping-cart text-primary"></i>
                                <span class="badge text-secondary border border-secondary rounded-circle" style="padding-bottom: 2px;">0</span>
                            </a>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</header>

<main role="main" class="flex-shrink-0">
    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</main>

<!-- Footer Start -->
<div class="container-fluid bg-dark text-secondary mt-5 pt-5">
    <div class="row px-xl-5 pt-5">
        <div class="col-lg-4 col-md-12 mb-5 pr-3 pr-xl-5">
            <h5 class="text-secondary text-uppercase mb-4">Contactos</h5>
            <p class="mb-2"><i class="fa fa-map-marker-alt text-primary mr-3"></i>Leiria, Potugal</p>
            <p class="mb-2"><i class="fa fa-envelope text-primary mr-3"></i>nexeltools@gmail.com</p>
            <p class="mb-0"><i class="fa fa-phone-alt text-primary mr-3"></i>+351 923 456 783</p>
        </div>
        <div class="col-lg-8 col-md-12">
            <div class="row">
                <div class="col-md-4 mb-5">
                    <h5 class="text-secondary text-uppercase mb-4">Compras</h5>
                    <div class="d-flex flex-column justify-content-start">
                        <a class="text-secondary mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Carrinho de Compras</a>
                        <a class="text-secondary mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Favoritos</a>
                        <a class="text-secondary mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Suporte</a>
                        <a class="text-secondary mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Marketplace</a>
                    </div>
                </div>
                <div class="col-md-4 mb-5">
                    <img src="<?= Yii::getAlias('@web') ?>/img/logo.png" alt="logo" style="width:150px; margin-left: 200px; border-radius: 5px;" >
                </div>

            </div>
        </div>
    </div>
    <div class="row border-top mx-xl-5 py-4" style="border-color: rgba(256, 256, 256, .1) !important;">
        <div class="col-md-6 px-xl-0">
            <p class="mb-md-0 text-center text-md-left text-secondary">
                &copy; NexelTools
            </p>
        </div>
        <div class="col-md-6 px-xl-0 text-center text-md-right">
            <img class="img-fluid" src="" alt="">
        </div>
    </div>
</div>
<a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage();
