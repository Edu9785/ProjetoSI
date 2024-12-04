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
                <div id="product-carousel" class="carousel slide produto-img" data-ride="carousel">
                    <div class="carousel-inner bg-light">
                        <?php foreach ($imagemUrls as $imagem): ?>
                        <div class="carousel-item active">
                            <img class="w-100 h-100" src="<?= $imagem ?>" alt="Image">
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <a class="carousel-control-prev" href="#product-carousel" data-slide="prev">
                        <i class="fa fa-2x fa-angle-left text-dark"></i>
                    </a>
                    <a class="carousel-control-next" href="#product-carousel" data-slide="next">
                        <i class="fa fa-2x fa-angle-right text-dark"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-7 h-auto mb-30">
                <div class="h-100 bg-light p-30 detalhes-produto">
                    <h3><?= Html::encode($model->nome) ?>
                        <h6><strong>Vendedor:</strong> <?= Html::encode($model->profile->user->username) ?></h6>
                    <div class="d-flex mb-3">
                        <h6><strong>Rating do vendedor:</strong></h6>
                        <div class="text-primary mr-2" style="margin: -2px 0 0 5px;">
                            <small class="fas fa-star"></small>
                            <small class="fas fa-star"></small>
                            <small class="fas fa-star"></small>
                            <small class="fas fa-star-half-alt"></small>
                            <small class="far fa-star"></small>
                        </div>
                    </div>
                    <h3 class="font-weight-semi-bold mb-4"><?= Html::encode($model->preco . '€') ?></h3>
                    <p class="mb-4"><?= Html::encode($model->desc)?></p>
                    <div class="d-flex align-items-center mb-4 pt-2">
                        <button class="btn btn-primary px- btnCart"><i class="fa fa-shopping-cart mr-1"></i> Adicionar ao Carrinho</button>
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
                        <a class="nav-item nav-link text-dark" data-toggle="tab" href="#tab-pane-3">Reviews (0)</a>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="tab-pane-1">
                            <h4 class="mb-3">Descrição do Produto</h4>
                            <p><?= Html::encode($model->desc) ?></p>
                        </div>
                        <div class="tab-pane fade" id="tab-pane-2">
                            <h4 class="mb-3">Informações</h4>
                            <p><strong>Produto: </strong><?= Html::encode($model->nome) ?></p>
                            <p><strong>Preço: </strong><?= Html::encode($model->preco . '€') ?></p>
                            <p><strong>Descrição: </strong><?= Html::encode($model->desc) ?></p>
                            <p><strong>Vendedor: </strong><?= Html::encode($model->profile->user->username) ?></p>
                            <p><strong>Telemóvel: </strong><?= Html::encode($model->profile->telemovel) ?></p>
                            <p><strong>Email: </strong><?= Html::encode($model->profile->user->email) ?></p>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="tab-pane-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <h4 class="mb-4">1 review for "Product Name"</h4>
                                    <div class="media mb-4">
                                        <img src="img/user.jpg" alt="Image" class="img-fluid mr-3 mt-1" style="width: 45px;">
                                        <div class="media-body">
                                            <h6>John Doe<small> - <i>01 Jan 2045</i></small></h6>
                                            <div class="text-primary mb-2">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star-half-alt"></i>
                                                <i class="far fa-star"></i>
                                            </div>
                                            <p>Diam amet duo labore stet elitr ea clita ipsum, tempor labore accusam ipsum et no at. Kasd diam tempor rebum magna dolores sed sed eirmod ipsum.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <h4 class="mb-4">Leave a review</h4>
                                    <small>Your email address will not be published. Required fields are marked *</small>
                                    <div class="d-flex my-3">
                                        <p class="mb-0 mr-2">Your Rating * :</p>
                                        <div class="text-primary">
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                        </div>
                                    </div>
                                    <form>
                                        <div class="form-group">
                                            <label for="message">Your Review *</label>
                                            <textarea id="message" cols="30" rows="5" class="form-control"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Your Name *</label>
                                            <input type="text" class="form-control" id="name">
                                        </div>
                                        <div class="form-group">
                                            <label for="email">Your Email *</label>
                                            <input type="email" class="form-control" id="email">
                                        </div>
                                        <div class="form-group mb-0">
                                            <input type="submit" value="Leave Your Review" class="btn btn-primary px-3">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <a href="<?= Url::to(['index']) ?>" class="btn btn-primary btn-sm btnVoltar">Voltar</a>
    </div>
</div>

