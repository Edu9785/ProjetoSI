<?php

use common\models\Produto;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Profile $model */

$this->title = "Perfil";
\yii\web\YiiAsset::register($this);
?>
<div class="profile-view">

    <h1 class="section-title position-relative text-uppercase mb-4">
    <span class="bg-secondary pr-3">
        <?= Html::encode($this->title) ?>
    </span>
    </h1>

    <div class="profile-details">
        <h3>Dados Pessoais:</h3>
        <div class="user-details">
            <p><strong>Username: </strong><?= Html::encode($model->user->username) ?></p>
            <p><strong>Nome: </strong> <?= Html::encode($model->nome)?></p>
            <p><strong>Email: </strong><?= Html::encode($model->user->email) ?></p>
            <p><strong>Morada: </strong><?= Html::encode($model->morada) ?></p>
            <p><strong>Telemóvel: </strong><?= Html::encode($model->telemovel) ?></p>
            <p><strong>NIF: </strong><?= Html::encode($model->nif) ?></p><br>
            <p>
                <?= Html::a('Editar  <i class="fas fa-pencil-alt"></i>', ['update', 'id' => $model->id], ['class' => 'btnEditarPerfil']) ?>
            </p>
        </div>
    </div>

    <div class="profile-historico">
        <h3>Histórico de Compras:</h3>
        <?php if (!empty($compras)): ?>
            <ul>
                <?php foreach ($compras as $compra): ?>
                    <li>
                        <div class="compra-info">
                            <strong>Data:</strong> <?= Html::encode($compra->datacompra) ?> |
                            <strong>Total:</strong> <?= Html::encode($compra->precototal) ?>€
                        </div>

                        <span class="compra-botoes">
                            <a href="<?= Url::to(['compra/view', 'id' => $compra->id]) ?>" class="btn btn-primary btn-sm">
                                Ver Detalhes
                            </a>
                            <a href="<?= Url::to(['fatura/view', 'id_compra' => $compra->id]) ?>" class="btn btn-primary btn-sm">
                                Ver Fatura
                            </a>
                        </span>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>Você ainda não realizou nenhuma compra.</p>
        <?php endif; ?>
    </div>

    <div class="profile-historico">
        <h3>Histórico de vendas:</h3>
        <?php if (!empty($produtosvendidos)): ?>
            <ul>
                <?php foreach ($produtosvendidos as $produto): ?>
                    <li>
                        <strong>Nome:</strong> <span class="produto-nome"><p><?= Html::encode($produto->nome) ?></p></span>|
                        <strong>Preço:</strong> <?= Html::encode($produto->preco) ?>€
                        <span>
                            <a href="<?= Url::to(['avaliacao/view', 'id_produto' => $produto->id]) ?>"
                               class="btn btn-info btn-sm" style="margin-left: 200px">Ver Review</a>
                        </span>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>Você ainda não realizou nenhuma venda.</p>
        <?php endif; ?>
    </div>

    <div class="produtos-vender">
        <h3>Produtos a vender:</h3>
        <div class="row px-xl-5 cards-vender">
            <div class="col-lg-3 col-md-4 col-sm-6 pb-1 card-add">
                <div class="product-item bg-light mb-4 border-thick text-center">
                    <div class="product-img position-relative overflow-hidden d-flex align-items-center justify-content-center">
                        <?= Html::a('<i class="fas fa-plus icon-plus"></i>', ['produto/create' , 'id_vendedor' => $model->id], ['class' => 'text-decoration-none btnPublicar']) ?>
                    </div>
                </div>
            </div>
            <?php foreach ($produtoVender as $venda): ?>
            <?php if($venda->estado == Produto::DISPONIVEL): ?>
                <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
                    <div class="product-item bg-light mb-4">
                        <div class="product-img position-relative overflow-hidden">
                            <img class="img-fluid w-100" src="<?= $imagemUrls[$venda->id] ?>" alt="" style="width: 100%; height: 200px; object-fit: cover">
                            <div class="product-action">
                                <a class="btn btn-outline-dark btn-square" href="<?= Url::to(['produto/update', 'id' => $venda->id]) ?>">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <a class="btn btn-outline-dark btn-square" href="<?= Url::to(['produto/delete', 'id' => $venda->id]) ?>"
                                   data-confirm="Quer mesmo retirar este produto de venda?"
                                   data-method="post">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif ?>
            <?php endforeach; ?>
        </div>
    </div>
</div>

