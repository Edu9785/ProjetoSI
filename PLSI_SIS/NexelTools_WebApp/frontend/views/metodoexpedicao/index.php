<?php

use common\models\Metodoexpedicao;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Envio';
?>
<div class="metodoexpedicao-index">

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

    <div class="row">
        <?php foreach ($metodoexpedicoes as $metodoexpedicao): ?>
            <div class="col-md-4 card-expedicao">
                <?= Html::a(
                    '<div class="card">
                        <div class="card-header">
                            <h5 class="card-title">' . Html::encode($metodoexpedicao->nome) . '</h5>
                        </div>
                        <div class="card-body">
                            <p><strong>Preço: ' . Html::encode($metodoexpedicao->preco) . ' €</strong></p>
                        </div>
                    </div>',
                    ['metodopagamento/index', 'id_metodoexpedicao' => $metodoexpedicao->id],
                    ['class' => 'text-decoration-none']
                ) ?>
            </div>
        <?php endforeach; ?>
    </div>

</div>

