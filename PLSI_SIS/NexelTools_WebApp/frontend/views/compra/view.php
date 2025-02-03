<?php

use common\models\Produto;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Compra $model */

$this->title = "Detalhes da Compra";
\yii\web\YiiAsset::register($this);
?>
<div class="compra-view">

    <h1 class="section-title position-relative text-uppercase mb-4">
        <span class="bg-secondary pr-3">
            <?= Html::encode($this->title) ?>
        </span>
    </h1>

    <!-- Checkout Start -->
    <div class="container-fluid position-relative">
        <div class="row px-xl-6">
            <div class="col-lg-8">
                <h5 class="section-title position-relative text-uppercase mb-3">
                    <span class="bg-secondary pr-3">Dados da encomenda</span>
                </h5>
                <div class="bg-light p-30 mb-5 checkout">
                    <div class="row">
                        <p><strong>Nome: </strong><?= Html::encode($model->profile->nome) ?></p>
                        <p><strong>Telemóvel: </strong><?= Html::encode($model->profile->telemovel) ?></p>
                        <p><strong>Nif: </strong><?= Html::encode($model->profile->nif) ?></p>
                        <p><strong>Morada: </strong><?= Html::encode($model->profile->morada) ?></p>
                        <p><strong>Data da Compra: </strong><?= Html::encode($model->datacompra) ?></p>
                        <p><strong>Pagamento: </strong><?= Html::encode($model->metodopagamento->nomemetodo) ?></p>
                        <p><strong>Método de Envio: </strong><?= Html::encode($model->metodoexpedicao->nome) ?></p>
                        <p><strong>Preço Total: </strong><?= Html::encode($model->precototal) . '€' ?></p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="top-0 z-index-1" style="width: 400px;">
                    <h5 class="section-title position-relative text-uppercase mb-3">
                        <span class="bg-secondary pr-3">Sumário</span>
                    </h5>
                    <div class="bg-light p-30 mb-5 checkout">
                        <div class="border-bottom">
                            <h6 class="mb-3">Produtos:</h6>
                            <?php foreach ($linhascompra as $linha): ?>
                                <div class="d-flex justify-content-between">
                                    <span><p><?= Html::encode($linha->produto->nome) ?></p></span>
                                    <p><?= Html::encode($linha->produto->preco . '€') ?></p>
                                    <div style="margin-top: -3px">
                                        <?php if($linha->produto->estado == Produto::EM_PROCESSAMENTO): ?>
                                            <p><strong><?= Html::encode("A processar...")?></strong></p>
                                        <?php elseif ($linha->produto->estado == Produto::EM_ENTREGA): ?>
                                            <?= Html::a('Confirmar Entrega',
                                                ['confirmar-entrega', 'id_produto' => $linha->produto->id],
                                                ['class' => 'btn btn-success btn-sm btnCompraView']
                                            ) ?>
                                        <?php else: ?>
                                            <?php if($linha->produto->avaliacao == null): ?>
                                                <?= Html::a('Deixar Review',
                                                    ['avaliacao/create', 'id_produto' => $linha->produto->id],
                                                    ['class' => 'btn btn-info btn-sm btnCompraView']
                                                )?>
                                            <?php else: ?>
                                                <?= Html::a('Editar Review',
                                                    ['avaliacao/update', 'id' => $linha->produto->avaliacao->id],
                                                    ['class' => 'btn btn-info btn-sm btnCompraView']
                                                )?>
                                                <?= Html::a('<i class="fa fa-trash"></i>',
                                                    ['avaliacao/delete', 'id' => $linha->produto->avaliacao->id],
                                                    ['class' => 'btn btn-danger btn-sm']
                                                )?>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                            <h6 class="mb-3">Envio:</h6>
                            <div class="d-flex justify-content-between align-items-center">
                                <p><?= Html::encode($model->metodoexpedicao->nome) ?></p>
                                <p><?= Html::encode($model->metodoexpedicao->preco . '€') ?></p>
                            </div>
                        </div>
                        <div class="pt-2">
                            <div class="d-flex justify-content-between mt-2">
                                <h5>Total</h5>
                                <h5><?= Html::encode($model->precototal . '€') ?></h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <a href="<?= Url::to(['profile/view', 'id' => Yii::$app->user->id]) ?>" class="btn btn-primary btn-sm btnVoltar">Voltar</a>
    </div>

</div>
