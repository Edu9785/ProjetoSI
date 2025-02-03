<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Compra $model */
/** @var yii\widgets\ActiveForm $form */

?>

<div class="compra-form">

    <?php $form = ActiveForm::begin(); ?>

    <!-- Checkout Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <!-- Coluna da Esquerda: Dados Pessoais -->
            <div class="col-lg-8">
                <h5 class="section-title position-relative text-uppercase mb-3">
                    <span class="bg-secondary pr-3">Dados Pessoais</span>
                </h5>
                <div class="bg-light p-30 mb-5 checkout">
                    <div class="row">
                        <div class="form-group">
                            <label>Nome:</label>
                            <input class="form-control" type="text" value="<?= $profile->nome ?>" placeholder="John">
                        </div>
                        <div class="form-group">
                            <label>E-mail</label>
                            <input class="form-control" type="text" value="<?= $profile->user->email ?>" placeholder="example@email.com">
                        </div>
                        <div class="form-group">
                            <label>Telemóvel</label>
                            <input class="form-control" type="text" value="+351 <?= $profile->telemovel ?>">
                        </div>
                        <div class="form-group">
                            <label>Morada</label>
                            <input class="form-control" type="text" value="<?= $profile->morada ?>">
                        </div>
                        <div class="form-group">
                            <label>Código Postal</label>
                            <input class="form-control" type="text" placeholder="Ex: 3260-302">
                        </div>
                    </div>
                </div>

                <!-- Métodos de Envio e Pagamento lado a lado -->
                <div class="row">
                    <div class="col-md-6">
                        <h5 class="section-title position-relative text-uppercase mb-3">
                            <span class="bg-secondary pr-3">Método de Expedição</span>
                        </h5>
                        <div class="bg-light p-30 mb-5 checkout">
                            <div class="form-group">
                                <label>Escolha o método de envio:</label>
                                <?= $form->field($model, 'id_metodoexpedicao')->dropDownList(
                                    ArrayHelper::map($metodoexpedicoes, 'id', 'nome'),
                                    ['prompt' => 'Escolha o método de Envio']
                                )->Label(false); ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <h5 class="section-title position-relative text-uppercase mb-3">
                            <span class="bg-secondary pr-3">Método de Pagamento</span>
                        </h5>
                        <div class="bg-light p-30 mb-5 checkout">
                            <div class="form-group">
                                <label>Escolha o método de pagamento:</label>
                                <?= $form->field($model, 'id_metodopagamento')->dropDownList(
                                    ArrayHelper::map($metodopagamentos, 'id', 'nomemetodo'),
                                    ['prompt' => 'Tipo de pagamento']
                                )->label(false); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Coluna da Direita: Sumário -->
            <div class="col-lg-4">
                <h5 class="section-title position-relative text-uppercase mb-3">
                    <span class="bg-secondary pr-3">Sumário</span>
                </h5>
                <div class="bg-light p-30 mb-5 checkout">
                    <div class="border-bottom">
                        <h6 class="mb-3">Produtos</h6>
                        <?php foreach ($linhascarrinho as $linha): ?>
                            <div class="d-flex justify-content-between">
                                <p><?= Html::encode($linha->produto->nome) ?></p>
                                <p><?= Html::encode($linha->produto->preco . '€') ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="pt-2">
                        <div class="d-flex justify-content-between mt-2">
                            <h5>Total</h5>
                            <h5><?= Html::encode($carrinho->precototal . '€') ?></h5>
                        </div>
                    </div>
                </div>

                <div class="mb-5">
                    <?= Html::submitButton('Fazer Compra', ['class' => 'btn btn-block btn-primary font-weight-bold py-3 btnFazerCompra']) ?>
                </div>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
