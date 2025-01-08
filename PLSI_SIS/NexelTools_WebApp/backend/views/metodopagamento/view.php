<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Metodopagamento $model */

$this->title = $model->nomemetodo;
\yii\web\YiiAsset::register($this);
?>
<div class="metodopagamento-view">

    <p>
        <?= Html::a('Editar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Quer deletar este item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'nomemetodo',
        ],
    ]) ?>

    <div class="row">
        <div class="col-lg-7">
            <a href="<?= Url::to(['index']) ?>" class="btn btn-primary btn-sm btnVoltar" style="margin: 20px 30px 40px 0">Voltar</a>
        </div>
    </div>

</div>
