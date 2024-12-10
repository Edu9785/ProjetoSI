<?php

use common\models\Imagem;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Categoria $model */

$this->title = $model->tipo;
\yii\web\YiiAsset::register($this);
?>
<div class="categoria-view">


    <p>
        <?= Html::a('Editar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Tem a certeza que quer eliminar este item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'tipo',
            [
                'attribute' => 'Imagem',
                'format' => 'raw',
                'value' => function ($model) use ($urlImagem) {
                    if ($urlImagem) {
                        return Html::img($urlImagem, ['alt' => 'Imagem', 'style' => 'width: 40px; height: auto;']);
                    } else {
                        return 'Imagem não encontrada';
                    }
                },
            ],
        ],
    ]) ?>
    <a href="<?= Url::to(['index']) ?>" class="btn btn-primary btn-sm btnVoltar">Voltar</a>
</div>
