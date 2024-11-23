<?php

use common\models\Profile;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Perfil';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="profile-index">

    <div class="profile-index">

        <div class="title-container">
            <h1><?= Html::encode($this->title) ?></h1>
            <div class="title-line"></div>
        </div>


        <div class="profile-details">
            <h3>Dados Pessoais:</h3>
            <div class="user-details">
                <p><strong>Username: </strong><?= Html::encode($profile->user->username) ?></p>
                <p><strong>Nome: </strong> <?= Html::encode($profile->nome)?></p>
                <p><strong>Email: </strong><?= Html::encode($profile->user->email) ?></p>
                <p><strong>Morada: </strong><?= Html::encode($profile->morada) ?></p>
                <p><strong>Telemóvel: </strong><?= Html::encode($profile->telemovel) ?></p>
                <p><strong>NIF: </strong><?= Html::encode($profile->nif) ?></p><br>
                <p>
                    <?= Html::a('Editar  <i class="fas fa-pencil-alt"></i>', ['update', 'id' => $profile->id], ['class' => 'btnEditarPerfil']) ?>
                </p>
            </div>
        </div>


        <div class="produtos-vender">
            <h3>Produtos a vender:</h3>
            <div class="row px-xl-5 cards-vender">
                <div class="col-lg-3 col-md-4 col-sm-6 pb-1 card-add">
                    <div class="product-item bg-light mb-4 border-thick text-center">
                        <div class="product-img position-relative overflow-hidden d-flex align-items-center justify-content-center">
                           <?= Html::a('<i class="fas fa-plus icon-plus"></i>', ['produto/create'], ['class' => 'text-decoration-none']) ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
                    <div class="product-item bg-light mb-4">
                        <div class="product-img position-relative overflow-hidden">
                            <img class="img-fluid w-100" src="<?= Yii::getAlias('@web') ?>/img/produto-2" alt="" style="width: 100%; height: 200px; object-fit: cover">
                            <div class="product-action">
                                <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-shopping-cart"></i></a>
                                <a class="btn btn-outline-dark btn-square" href=""><i class="far fa-heart"></i></a>
                                <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-search"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
                    <div class="product-item bg-light mb-4">
                        <div class="product-img position-relative overflow-hidden">
                            <img class="img-fluid w-100" src="<?= Yii::getAlias('@web') ?>/img/produto-3.jpg" alt="" style="width: 100%; height: 200px; object-fit: cover">
                            <div class="product-action">
                                <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-shopping-cart"></i></a>
                                <a class="btn btn-outline-dark btn-square" href=""><i class="far fa-heart"></i></a>
                                <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-search"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
                    <div class="product-item bg-light mb-4">
                        <div class="product-img position-relative overflow-hidden">
                            <img class="img-fluid w-100" src="<?= Yii::getAlias('@web') ?>/img/produto-4.jpg" alt="" style="width: 100%; height: 200px; object-fit: cover">
                            <div class="product-action">
                                <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-shopping-cart"></i></a>
                                <a class="btn btn-outline-dark btn-square" href=""><i class="far fa-heart"></i></a>
                                <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-search"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
