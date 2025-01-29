<?php

use frontend\models\Favorito;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Lista de Favoritos';

?>
<div class="favorito-index">

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
                        <th>Carrinho</th>
                        <th>Remover</th>
                    </tr>
                    </thead>
                    <tbody class="align-middle">
                    <?php if(Yii::$app->user->isGuest): ?>
                        <tr>
                            <p>Faça login para ver a sua lista de favoritos...</p>
                        </tr>
                    <?php elseif(empty($favoritos)): ?>
                        <tr>
                            <p>Sem produtos na lista de favoritos...</p>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($favoritos as $favorito): ?>
                            <tr>
                                <td class="align-middle"> <?= Html::encode($favorito->produto->nome) ?></td>
                                <td class="align-middle"><?= Html::encode($favorito->produto->preco . "€") ?></td>
                                <td class="align-middle"><?= Html::encode($favorito->produto->profile->user->username) ?></td>
                                <td class="align-middle"><?= Html::a( '<i class="fas fa-cart-plus"></i>', ['carrinhocompra/create', 'id_produto' => $favorito->produto->id], ['class' => 'btn btn-sm btn-warning'])?></td>
                                <td class="align-middle"><?= Html::a( '<i class="fa fa-times"></i>', ['favorito/delete', 'id' => $favorito->id], ['class' => 'btn btn-sm btn-danger'])?></td>
                            </tr>
                        <?php endforeach;?>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
