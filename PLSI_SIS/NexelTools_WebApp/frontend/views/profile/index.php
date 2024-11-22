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
            <h3>Produtos a venda:</h3>
            <div class="product-cards">
                <div class="card-adicionar">
                    <img src="image1.jpg" alt="Produto 1" class="card-image">

                </div>

                <div class="card">
                    <img src="image2.jpg" alt="Produto 2" class="card-image">
                </div>

                <div class="card">
                    <img src="image3.jpg" alt="Produto 3" class="card-image">

                </div>
            </div>
        </div>
    </div>
</div>
