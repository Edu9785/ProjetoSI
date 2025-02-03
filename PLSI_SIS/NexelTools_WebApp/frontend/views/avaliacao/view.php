<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Avaliacao $model */

$this->title = 'Review';
\yii\web\YiiAsset::register($this);
?>
<div class="avaliacao-view">

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
                    <h3><?= Html::encode($produto->nome) ?>
                        <h6><strong>Vendedor:</strong> <?= Html::encode($produto->profile->user->username) ?></h6>
                        <div class="d-flex mb-3">
                            <h6><strong>Rating do vendedor:</strong> <?= Html::encode($produto->profile->avaliacao) ?></h6>
                            <div class="text-primary mr-2" style="margin: -3.5px 0 0 2px;">
                                <small class="fas fa-star"></small>
                            </div>
                        </div>
                        <h3 class="font-weight-semi-bold mb-4"><?= Html::encode($produto->preco . '€') ?></h3>
                        <h3 class="font-weight-semi-bold mb-4">Contactos:</h3>
                        <p>Telemóvel: <?= Html::encode($produto->profile->telemovel) ?></p>
                        <p>Email: <?= Html::encode($produto->profile->user->email) ?></p>
                </div>
            </div>
        </div>
        <div class="row px-xl-5">
            <div class="col">
                <div class="bg-light p-30 reviewsZone">
                    <div class="row">
                        <div class="col-12">
                            <h4 class="mb-4">Review de <?= Html::encode($produto->nome) ?></h4>
                            <?php if ($model !== null): ?>
                                <div style="padding: 5px 20px">
                                    <h5><strong>Username: <?= Html::encode($model->profile->user->username) ?></strong></h5>
                                    <div style="padding: 10px 30px">
                                        <div class="d-flex mb-3">
                                            <h6>Rating: <?= Html::encode($model->avaliacao) ?></h6>
                                            <div class="text-primary mr-2" style="margin: -3.5px 0 0 2px;">
                                                <small class="fas fa-star"></small>
                                            </div>
                                        </div>
                                        <h6>Comentário:</h6>
                                        <p><?= Html::encode($model->desc) ?></p>
                                    </div>
                                </div>
                            <?php else: ?>
                                <div style="padding: 5px 20px">
                                    <p><strong>Ainda não há avaliações para este produto.</strong></p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <a href="<?= Url::to(['profile/view', 'id' => Yii::$app->user->id]) ?>" class="btn btn-primary btn-sm btnVoltar" style="margin-left: 60px">Voltar</a>


</div>
