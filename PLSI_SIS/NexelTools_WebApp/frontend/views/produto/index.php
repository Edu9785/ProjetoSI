<?php

use common\models\Produto;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use common\Models\Imagem;
use common\models\Imagemproduto;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Produtos';
?>
<div class="produto-index">

    <h1 class="section-title position-relative text-uppercase mb-4">
    <span class="bg-secondary pr-3">
        <?= Html::encode($this->title) ?>
    </span>
    </h1>

    <!-- Shop Start -->
    <div class="container-fluid" style="margin-top: 30px;">
        <div class="row px-xl-5">
            <!-- Shop Sidebar Start -->
            <div class="col-lg-3 col-md-4">
                <!-- Price Start -->
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Filtrar por preço</span></h5>
                <div class="bg-light p-4 mb-30">
                    <form method="get" action="<?= Url::to(['produto/index']) ?>">
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" name="preco[]" value="todos"  checked id="price-all" onchange="this.form.submit();">
                            <label class="custom-control-label" for="price-all">Todos</label>
                        </div>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" name="preco[]" value="0-20" id="price-1" onchange="this.form.submit();">
                            <label class="custom-control-label" for="price-1">0€ - 20€</label>
                        </div>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" name="preco[]" value="20-50" id="price-2" onchange="this.form.submit();">
                            <label class="custom-control-label" for="price-2">20€ - 50€</label>
                        </div>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" name="preco[]" value="50-100" id="price-3" onchange="this.form.submit();">
                            <label class="custom-control-label" for="price-3">50€ - 100€</label>
                        </div>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" name="preco[]" value="100 - 200" id="price-4" onchange="this.form.submit();">
                            <label class="custom-control-label" for="price-4">100€ - 200€</label>
                        </div>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between">
                            <input type="checkbox" class="custom-control-input" name="preco[]" value="200-" id="price-5" onchange="this.form.submit();">
                            <label class="custom-control-label" for="price-5">>200€</label>
                        </div>
                    </form>
                </div>
                <!-- Price End -->
            </div>
            <!-- Shop Sidebar End -->


            <!-- Shop Product Start -->
            <div class="col-lg-9 col-md-8">
                <div class="row pb-3">
                    <?php foreach ($produtos as $produto): ?>
                    <div class="col-lg-4 col-md-6 col-sm-6 pb-1">
                        <div class="product-item bg-light mb-4">
                            <div class="product-img position-relative overflow-hidden">
                                <img class="img-fluid w-100" src="<?= $imagemUrls[$produto->id] ?>" alt="Produto">
                                <div class="product-action">
                                    <a class="btn btn-outline-dark btn-square" href="<?= Url::to(['carrinhocompra/create', 'id_produto' => $produto->id]) ?>"><i class="fa fa-shopping-cart"></i></a>
                                    <a class="btn btn-outline-dark btn-square" href=""><i class="far fa-heart"></i></a>
                                    <a class="btn btn-outline-dark btn-square" href="<?= Url::to(['view', 'id' => $produto->id]) ?>"><i class="fa fa-search"></i></a>
                                </div>
                            </div>
                            <div class="text-center py-4">
                                <a class="h6 text-decoration-none text-truncate" href=""><?= Html::encode($produto->nome) ?></a>
                                <div class="d-flex align-items-center justify-content-center mt-2">
                                    <h5><?= Html::encode($produto->preco . '€') ?></h5>
                                </div>
                                <div class="d-flex align-items-center justify-content-center mb-1">
                                    <small class="fa fa-star text-primary mr-1"></small>
                                    <small class="fa fa-star text-primary mr-1"></small>
                                    <small class="fa fa-star text-primary mr-1"></small>
                                    <small class="fa fa-star text-primary mr-1"></small>
                                    <small class="fa fa-star text-primary mr-1"></small>
                                    <small>(99)</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <!-- Shop Product End -->
        </div>
    </div>
</div>