<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Fatura $model */

$this->title = 'Fatura';
\yii\web\YiiAsset::register($this);
?>
<div class="fatura-view">

    <h1 class="section-title position-relative text-uppercase mb-4">
        <span class="bg-secondary pr-3">
            <?= Html::encode($this->title) ?>
        </span>
    </h1>

    <div class="fatura-body">
        <div class="fatura-header">
            <div>
                <h3><strong>DE</strong></h3>
                <p>NexelTools</p>
                <p>Leiria, Portugal</p>
                <h3 style="margin-top: 80px"><strong>Cobrar A</strong></h3>
                <p><?= Html::encode($profile->nome) ?></p>
                <p><?= Html::encode($profile->morada) ?></p>
            </div>
            <div class="fatura-detalhes">
                <h3><strong>Enviar Para</strong></h3>
                <p><?= Html::encode($profile->nome) ?></p>
                <p><?= Html::encode($profile->morada) ?></p>
                <p><strong>Data da Fatura: </strong> <?= Html::encode($model->datahora) ?></p>
            </div>
        </div>
        <hr>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Descrição</th>
                <th>Vendedor</th>
                <th>Valor</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($linhasfatura as $linha): ?>
                <tr>
                    <td><?= Html::encode($linha->produto->nome) ?></td>
                    <td><?= Html::encode($linha->produto->profile->user->username) ?></td>
                    <td><?= Html::encode($linha->produto->preco) ?> €</td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <div style="margin-top: 40px;">
            <p><strong>Envio: </strong><?= Html::encode($model->compra->metodoexpedicao->preco) ?>€</p>
            <p><strong>Total: </strong><?= Html::encode($model->precofatura) ?>€</p>
        </div>
    </div>
    <a href="<?= Url::to(['profile/view', 'id' => Yii::$app->user->id]) ?>" class="btn btn-primary btn-sm btnVoltar" style="margin-left: 50px">Voltar</a>
</div>
