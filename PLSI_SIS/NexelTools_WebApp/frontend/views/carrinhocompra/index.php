<?php

use frontend\models\Carrinhocompra;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Carrinho';
?>
<div class="carrinhocompra-index">

    <h1 class="section-title position-relative text-uppercase mb-4">
    <span class="bg-secondary pr-3">
        <?= Html::encode($this->title) ?>
    </span>
    </h1>

    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-lg-8 table-responsive mb-5">
                <table class="table table-light table-borderless table-hover text-center mb-0">
                    <thead class="thead-dark">
                    <tr>
                        <th>Produto</th>
                        <th>Preço</th>
                        <th>Vendedor</th>
                        <th>Remover</th>
                    </tr>
                    </thead>
                    <tbody class="align-middle">
                    <?php if(Yii::$app->user->isGuest): ?>
                        <p>Faça Login para adicionar produtos ao carrinho...</p>
                    <?php elseif(empty($linhacarrinho)): ?>
                        <p>Carrinho de Compras vazio...</p>
                    <?php else: ?>
                        <?php foreach ($linhacarrinho as $linha): ?>
                        <tr>
                            <td class="align-middle"> <?= Html::encode($linha->produto->nome) ?></td>
                            <td class="align-middle"><?= Html::encode($linha->produto->preco . "€") ?></td>
                            <td class="align-middle"><?= Html::encode($linha->produto->profile->user->username) ?></td>
                            <td class="align-middle"><?= Html::a( '<i class="fa fa-times"></i>', ['carrinhocompra/delete', 'id_linha' => $linha->id], ['class' => 'btn btn-sm btn-danger'])?></td>
                        </tr>
                        <?php endforeach;?>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="col-lg-4">
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Sumário</span></h5>
                <div class="bg-light p-30 mb-5">
                    <div class="border-bottom pb-2">
                        <div class="d-flex justify-content-between mt-2">
                            <h5>Total</h5>
                            <h5><?= Html::encode(($carrinho->precototal ?? 0) . "€") ?></h5>
                        </div>
                    </div>
                    <div class="pt-2">
                        <a href="<?= Url::to(['compra/create']) ?>" class="btn btn-block btn-primary font-weight-bold my-3 py-3">Tratar pedido</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
