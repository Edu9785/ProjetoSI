<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use common\Models\Imagemproduto;
use common\Models\Imagem;

/** @var yii\web\View $this */
/** @var common\models\Produto $model */

$this->title = $model->nome;
\yii\web\YiiAsset::register($this);
?>
<div class="produto-view">

    <h1 class="section-title position-relative text-uppercase mb-4">
    <span class="bg-secondary pr-3">
        <?= Html::encode($this->title) ?>
    </span>
    </h1>

    <div class="container-fluid pb-5" style="margin-top: 30px;">
        <div class="row px-xl-5">
            <div class="col-lg-5 mb-30">
                <div id="product-carousel" class="carousel slide produto-img carousel-fade" data-ride="carousel" >
                    <div class="carousel-inner bg-light">
                        <?php foreach ($imagemUrls as $index => $imagem): ?>
                            <div class="carousel-item <?= $index == 0 ? 'active' : '' ?>">
                                <img class="w-100 h-100" src="<?= $imagem ?>" alt="Image">
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <a class="carousel-control-prev" href="#product-carousel" data-slide="prev">
                        <i class="fa fa-2x fa-angle-left text-white"></i>
                    </a>
                    <a class="carousel-control-next" href="#product-carousel" data-slide="next">
                        <i class="fa fa-2x fa-angle-right text-white"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-7 h-auto mb-30">
                <div class="h-100 bg-light p-30 detalhes-produto">
                    <h3><?= Html::encode($model->nome) ?>
                        <h6><strong>Vendedor:</strong> <?= Html::encode($model->profile->user->username) ?></h6>
                    <div class="d-flex mb-3">
                        <h6><strong>Rating do vendedor:</strong><?= Html::encode($model->profile->avaliacao) ?></h6>
                        <div class="text-primary mr-2" style="margin: -3.5px 0 0 2px;">
                            <small class="fas fa-star"></small>
                        </div>
                    </div>
                    <h3 class="font-weight-semi-bold mb-4"><?= Html::encode($model->preco . '€') ?></h3>
                        <h3 class="font-weight-semi-bold mb-4">Contactos:</h3>
                        <p>Telemóvel: <?= Html::encode($model->profile->telemovel) ?></p>
                        <p>Email: <?= Html::encode($model->profile->user->email) ?></p>
                    <div class="d-flex align-items-center mb-4 pt-2">

                        <?php if (Yii::$app->user->isGuest): ?>
                            <?= Html::a('<i class="fa fa-shopping-cart mr-1"></i> Adicionar ao Carrinho', ['#'], [
                                'class' => "btn btn-primary px- btnCart",
                                'onclick' => 'alert("Faça login para adicionar um produto!"); return false;']) ?>
                        <?php else: ?>
                            <?= Html::a('<i class="fa fa-shopping-cart mr-1"></i> Adicionar ao Carrinho', ['carrinhocompra/create', 'id_produto' => $model->id], ['class'=>'btn btn-primary px- btnCart']) ?>
                        <?php endif; ?>

                        <?php if (Yii::$app->user->isGuest): ?>
                            <?= Html::a('<i class="fa fa-heart"></i>', ['#'], [
                                'class' => "btn btn-primary px- btnAddFav",
                                'onclick' => 'alert("Faça login para adicionar um favorito!"); return false;']) ?>
                        <?php else: ?>
                            <?= Html::a('<i class="fa fa-heart"></i>', ['favorito/create', 'id_produto' => $model->id], ['class'=>'btn btn-primary px- btnAddFav']) ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row px-xl-5">
            <div class="col ">
                <div class="bg-light p-30 reviewsZone">
                    <div class="nav nav-tabs mb-4">
                        <a class="nav-item nav-link text-dark active" data-toggle="tab" href="#tab-pane-1">Descrição</a>
                        <a class="nav-item nav-link text-dark" data-toggle="tab" href="#tab-pane-2">Informações</a>
                        <a class="nav-item nav-link text-dark" data-toggle="tab" href="#tab-pane-3">Reviews (<?= Html::encode($reviewsCount) ?>)</a>
                    </div>
                    <div class="tab-content">
                        <!-- Aba 1: Descrição -->
                        <div class="tab-pane fade show active" id="tab-pane-1">
                            <h4 class="mb-3">Descrição do Produto</h4>
                            <p><?= Html::encode($model->desc) ?></p>
                        </div>

                        <!-- Aba 2: Informações -->
                        <div class="tab-pane fade" id="tab-pane-2">
                            <h4 class="mb-3">Informações</h4>
                            <p><strong>Produto: </strong><?= Html::encode($model->nome) ?></p>
                            <p><strong>Preço: </strong><?= Html::encode($model->preco . '€') ?></p>
                            <p><strong>Vendedor: </strong><?= Html::encode($model->profile->user->username) ?></p>
                            <p><strong>Telemóvel: </strong><?= Html::encode($model->profile->telemovel) ?></p>
                            <p><strong>Email: </strong><?= Html::encode($model->profile->user->email) ?></p>
                        </div>

                        <!-- Aba 3: Reviews -->
                        <div class="tab-pane fade reviews" id="tab-pane-3">
                            <div class="row">
                                <div class="col">
                                    <h4 class="mb-4">Reviews de <?= Html::encode($model->profile->user->username) ?></h4>
                                    <?php foreach ($reviews as $review): ?>
                                        <div style="padding: 5px 20px">
                                            <h5><strong>Username: <?= Html::encode($review->profile->user->username) ?></strong></h5>
                                            <div style="padding: 10px 30px">
                                                <div class="d-flex mb-3">
                                                    <h6>Rating: <?= Html::encode($review->avaliacao) ?></h6>
                                                    <div class="text-primary mr-2" style="margin: -3.5px 0 0 2px;">
                                                        <small class="fas fa-star"></small>
                                                    </div>
                                                </div>
                                                <h6>Comentário:</h6>
                                                <p><?= Html::encode($review->desc) ?></p>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <a href="<?= Url::to(['index']) ?>" class="btn btn-primary btn-sm btnVoltar" style="margin-left: 60px">Voltar</a>
</div>


