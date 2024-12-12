<?php

use common\models\Metodopagamento;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Pagamento';
?>
<div class="metodopagamento-index">

    <div class="checkout-passos">
        <ul class="passos">
            <li class="nav-item">
                <div class="numero active">1</div>
                <span><strong>Dados</strong></span>
            </li>
            <li class="linha"></li>
            <li class="nav-item">
                <div class="numero active">2</div>
                <span><strong>Envio</strong></span>
            </li>
            <li class="linha"></li>
            <li class="nav-item">
                <div class="numero active">3</div>
                <span><strong>Pagamento</strong></span>
            </li>
        </ul>
    </div>

    <h1 class="section-title position-relative text-uppercase mb-4">
    <span class="bg-secondary pr-3">
        <?= Html::encode($this->title) ?>
    </span>
    </h1>

    <div class="row">
            <div class="col-md-4 card-expedicao">
                <?= Html::a(
                    '<div class="card">
                        <div class="card-header">
                            <h5 class="card-title"></h5>
                        </div>
                        <div class="card-body">
                            <p><strong>Mbway</strong></p>
                        </div>
                    </div>',
                    ['compra/create'],
                    ['class' => 'text-decoration-none']
                ) ?>
                <?= Html::a('Adicionar MbWay', ['mbway/create']) ?>
            </div>
            <div class="col-md-4 card-expedicao">
                <?= Html::a(
                    '<div class="card">
                            <div class="card-header">
                                <h5 class="card-title"></h5>
                            </div>
                            <div class="card-body">
                                <p><strong>Visa</strong></p>
                            </div>
                        </div>',
                    ['class' => 'text-decoration-none']
                ) ?>
            </div>
</div>
