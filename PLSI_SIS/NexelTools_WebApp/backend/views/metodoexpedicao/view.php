<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Metodoexpedicao $model */

$this->title = $model->nome;
\yii\web\YiiAsset::register($this);
?>
<div class="metodoexpedicao-view">
    <div class="card-expedicao">
        <p><strong>Nome: </strong> <?= Html::encode($model->nome) ?></p>
        <p><strong>Preço: </strong> <?= Html::encode($model->preco . '€') ?></p>
        <p>
            <?= Html::a('Editar', ['update', 'id' => $model->id], ['class' => 'btn btn-warning']) ?>
            <?= Html::a('Eliminar', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Tem a certeza que quer deletar este item?',
                    'method' => 'post',
                ],
            ]) ?>
        </p>
    </div>

    <?= Html::a('Voltar', ['index'], ['class' => 'btn btn-primary btnVoltar']) ?>

</div>
