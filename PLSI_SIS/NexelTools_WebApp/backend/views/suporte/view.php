<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Suporte $model */

$this->title = $model->assunto;

\yii\web\YiiAsset::register($this);
?>
<div class="suporte-view">

    <p>
        <?= Html::a('Encerrar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-success btn-sm',
            'data' => [
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'User',
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->profile->user->username;
                },
            ],
            [
                'attribute' => 'Assunto',
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->assunto;
                },
            ],
            [
                'attribute' => 'Problema',
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->desc;
                },
            ],
        ],
    ]) ?>

    <div class="row">
        <div class="col-lg-7">
            <a href="<?= Url::to(['index']) ?>" class="btn btn-primary btn-sm btnVoltar" style="margin: 20px 30px 40px 0">Voltar</a>
        </div>
    </div>
</div>
