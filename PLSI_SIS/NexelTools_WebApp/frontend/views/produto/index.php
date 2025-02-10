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
                <h5 class="section-title position-relative text-uppercase mb-3">
                    <span class="bg-secondary pr-3">Filtrar por preço</span>
                </h5>
                <div class="bg-light p-4 mb-30">
                    <form method="get" action="<?= Url::to(['produto/index']) ?>">
                        <?php
                        $precoOptions = [
                            'todos' => 'Todos',
                            '0-20' => '0€ - 20€',
                            '20-50' => '20€ - 50€',
                            '50-100' => '50€ - 100€',
                            '100-200' => '100€ - 200€',
                            '200-' => '>200€'
                        ];
                        $selectedPrecos = Yii::$app->request->get('preco', ['todos']);
                        foreach ($precoOptions as $value => $label) : ?>
                            <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                                <input type="checkbox"
                                       class="custom-control-input"
                                       name="preco[]"
                                       value="<?= Html::encode($value) ?>"
                                       id="price-<?= Html::encode($value) ?>"
                                       onchange="this.form.submit();"
                                    <?= in_array($value, $selectedPrecos) ? 'checked' : '' ?>>
                                <label class="custom-control-label" for="price-<?= Html::encode($value) ?>"><?= Html::encode($label) ?></label>
                            </div>
                        <?php endforeach; ?>
                    </form>
                </div>
                <!-- Price End -->
            </div>
            <!-- Shop Sidebar End -->

            <!-- Shop Product Start -->
            <div class="col-lg-9 col-md-8">
                <div class="row pb-3">
                    <?php foreach ($produtos as $produto): ?>
                    <?php if($produto->estado == Produto::DISPONIVEL): ?>
                    <div class="col-lg-4 col-md-6 col-sm-6 pb-1">
                        <div class="product-item bg-light mb-4">
                            <div class="product-img position-relative overflow-hidden">
                                <img class="img-fluid w-100" src="<?= $imagemUrls[$produto->id] ?>" alt="Produto">
                                <div class="product-action">
                                    <?php if (Yii::$app->user->isGuest): ?>
                                        <?= Html::a('<i class="fa fa-shopping-cart"></i>', ['#'], [
                                            'class' => "btn btn-outline-dark btn-square",
                                            'onclick' => 'alert("Faça login para adicionar um produto!"); return false;']) ?>
                                    <?php else: ?>
                                        <a class="btn btn-outline-dark btn-square" href="<?= Url::to(['carrinhocompra/create', 'id_produto' => $produto->id]) ?>"><i class="fa fa-shopping-cart"></i></a>
                                    <?php endif; ?>
                                    <?php if (Yii::$app->user->isGuest): ?>
                                        <?= Html::a('<i class="far fa-heart"></i>', ['#'], [
                                            'class' => "btn btn-outline-dark btn-square",
                                            'onclick' => 'alert("Faça login para adicionar um favorito!"); return false;']) ?>
                                    <?php else: ?>
                                    <a class="btn btn-outline-dark btn-square" href="<?= Url::to(['favorito/create', 'id_produto' => $produto->id]) ?>"><i class="far fa-heart"></i></a>
                                    <?php endif; ?>
                                    <a class="btn btn-outline-dark btn-square btnVerProduto" href="<?= Url::to(['view', 'id' => $produto->id]) ?>"><i class="fa fa-search"></i></a>
                                </div>
                            </div>
                            <div class="text-center py-4">
                                <a class="h6 text-decoration-none text-truncate" href=""><?= Html::encode($produto->nome) ?></a>
                                <div class="d-flex align-items-center justify-content-center mt-2">
                                    <h5><?= Html::encode($produto->preco . '€') ?></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                        <?php endif ?>
                    <?php endforeach; ?>
                </div>
            </div>
            <!-- Shop Product End -->
        </div>
    </div>
</div>