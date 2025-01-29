<?php

use yii\helpers\Html;

?>
<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <!-- SEARCH FORM -->
    <!-- <form class="form-inline ml-3">
        <div class="input-group input-group-sm">
            <input class="form-control form-control-navbar" type="search" placeholder="Pesquisar" aria-label="Search">
            <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </form>-->

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Messages Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-comments"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <?php $mensagens = \common\models\Suporte::find()->limit(5)->all(); ?>
                <?php if (!empty($mensagens)): ?>
                    <?php foreach ($mensagens as $mensagem): ?>
                        <a href="<?= \yii\helpers\Url::to(['view', 'id' => $mensagem->id]) ?>" class="dropdown-item">
                            <!-- Message Start -->
                            <div class="media-body">
                                <strong><h3 class="dropdown-item-title">
                                    <?= \yii\helpers\Html::encode($mensagem->profile->user->username) ?>
                                </h3></strong>
                                <p class="text-sm">
                                    <?= \yii\helpers\Html::encode($mensagem->desc) ?>
                                </p>
                            </div>
                            <!-- Message End -->
                        </a>
                    <?php endforeach; ?>
                <?php else: ?>
                    <a href="#" class="dropdown-item">
                        <!-- Message Start -->
                        <div class="media">
                            <div class="media-body">
                                <p>Nenhuma mensagem disponível.</p>
                            </div>
                        </div>
                        <!-- Message End -->
                    </a>
                <?php endif; ?>
                <div class="dropdown-divider"></div>
                <a href="<?= \yii\helpers\Url::to('index') ?>" class="dropdown-item dropdown-footer">Ver Todas as Mensagens</a>
            </div>
        </li>
        <li class="nav-item">
            <?= Html::a('<i class="fas fa-sign-out-alt"></i>', ['/site/logout'], ['data-method' => 'post', 'class' => 'nav-link']) ?>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                <i class="fas fa-th-large"></i>
            </a>
        </li>
    </ul>
</nav>
<!-- /.navbar -->