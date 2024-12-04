<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Produto $model */

$this->title = $model->nome;
\yii\web\YiiAsset::register($this);
?>
<div class="produto-view">

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
            [
                'attribute' => 'Vendedor',
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->profile->user->username;
                },
            ],
            [
                'attribute' => 'Preço',
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->preco;
                },
            ],
            [
                'attribute' => 'Descrição',
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->desc;
                },
            ],
            [
                'attribute' => 'Categoria',
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->categoria->tipo;
                },
            ],
            [
                'attribute' => 'Nome',
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->nome;
                },
            ],
            [
                'attribute' => 'Estado',
                'format' => 'raw',
                'value' => function ($model) {
                        if($model->estado == 0){
                            return Html::encode("Disponível");
                        }else if($model->estado == 1){
                            return Html::encode("Em entrega");
                        }else{
                            return Html::encode("Entregue");
                        }
                },
            ],
        ],
    ]) ?>

</div>
