<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Avaliacao $model */

$this->title = 'Review de ' . $model->produto->nome;

\yii\web\YiiAsset::register($this);
?>
<div class="avaliacao-view">

    <p>
        <?= Html::a('Editar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Quer eliminar este item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'Publicado por',
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->profile->user->username;
                },
            ],
            [
                'attribute' => 'Comentário',
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->desc;
                },
            ],
            [
                'attribute' => 'Rating',
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->avaliacao;
                },
            ],
            [
                'attribute' => 'Produto',
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->produto->nome;
                },
            ],
        ],
    ]) ?>

    <div class="row">
        <div class="col-lg-7">
            <a href="<?= Url::to(['produto/view', 'id' => $model->produto->id]) ?>" class="btn btn-primary btn-sm btnVoltar" style="margin: 20px 30px 40px 0">Voltar</a>
        </div>
    </div>

</div>
