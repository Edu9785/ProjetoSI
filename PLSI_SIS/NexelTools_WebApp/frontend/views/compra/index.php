<?php

use common\models\Compra;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Checkout';
?>
<div class="compra-index">

    <div class="checkout-passos">
        <ul class="passos">
            <li class="nav-item">
                <div class="numero active">1</div>
                <span><strong>Dados</strong></span>
            </li>
            <li class="linha"></li>
            <li class="nav-item">
                <div class="numero">2</div>
                <span><strong>Envio</strong></span>
            </li>
            <li class="linha"></li>
            <li class="nav-item">
                <div class="numero">3</div>
                <span><strong>Pagamento</strong></span>
            </li>
        </ul>
    </div>

    <h1 class="section-title position-relative text-uppercase mb-4">
    <span class="bg-secondary pr-3">
        <?= Html::encode($this->title) ?>
    </span>
    </h1>

    <!-- Checkout Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-lg-8">
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Dados pessoais</span></h5>
                <div class="bg-light p-30 mb-5">
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
                <div class="collapse mb-5" id="shipping-address">
                    <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3"></span></h5>
                    <div class="bg-light p-30">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label>First Name</label>
                                <input class="form-control" type="text" placeholder="John">
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Last Name</label>
                                <input class="form-control" type="text" placeholder="Doe">
                            </div>
                            <div class="col-md-6 form-group">
                                <label>E-mail</label>
                                <input class="form-control" type="text" placeholder="example@email.com">
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Mobile No</label>
                                <input class="form-control" type="text" placeholder="+123 456 789">
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Address Line 1</label>
                                <input class="form-control" type="text" placeholder="123 Street">
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Address Line 2</label>
                                <input class="form-control" type="text" placeholder="123 Street">
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Country</label>
                                <select class="custom-select">
                                    <option selected>United States</option>
                                    <option>Afghanistan</option>
                                    <option>Albania</option>
                                    <option>Algeria</option>
                                </select>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>City</label>
                                <input class="form-control" type="text" placeholder="New York">
                            </div>
                            <div class="col-md-6 form-group">
                                <label>State</label>
                                <input class="form-control" type="text" placeholder="New York">
                            </div>
                            <div class="col-md-6 form-group">
                                <label>ZIP Code</label>
                                <input class="form-control" type="text" placeholder="123">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Sumário</span></h5>
                <div class="bg-light p-30 mb-5">
                    <div class="border-bottom">
                        <h6 class="mb-3">Produtos</h6>
                        <?php foreach($linhascarrinho as $linha):  ?>
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
                    <a href="<?= Url::to(['metodoexpedicao/index']) ?>" class="btn btn-block btn-primary font-weight-bold py-3">Seguinte</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Checkout End -->
</div>
