<?php

use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\compra $model */

$this->title = 'Compra de ' . $model->profile->user->username;
\yii\web\YiiAsset::register($this);
?>
<div class="compra-view">


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'Comprador',
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->profile->user->username;
                },
            ],
            [
                'attribute' => 'Data da compra',
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->datacompra;
                },
            ],
            [
                'attribute' => 'Preço Total',
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->precototal . '€';
                },
            ],
            [
                'attribute' => 'Pagamento',
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->metodopagamento->nomemetodo;
                },
            ],
            [
                'attribute' => 'Expedição',
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->metodoexpedicao->nome;
                },
            ],
        ],
    ]) ?>

    <h3>Produtos da Compra</h3>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'summary' => '',
        'columns' => [
            [
                'attribute' => 'Produto',
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->produto->nome;
                },
            ],
            [
                'attribute' => 'Vendedor',
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->produto->profile->user->username;
                },
            ],
            [
                'attribute' => 'Preço',
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->produto->preco.'€';
                },
            ],
            [
                'attribute' => 'Estado',
                'format' => 'raw',
                'value' => function ($model) {
                    if($model->produto->estado == \common\models\Produto::EM_PROCESSAMENTO){
                        return 'A processar...';
                    }

                    if($model->produto->estado == \common\models\Produto::EM_ENTREGA){
                        return 'Em entrega...';
                    }

                    return 'Entregue';
                },
            ],
        ],
        'rowOptions' => function ($model) {
                return [
                    'data-url' => Url::to(['produto/view', 'id' => $model->produto->id]),
                    'class' => 'clickable-row',
                    'style' => 'cursor: pointer;'
                ];
            },
    ]); ?>

    <?php

    $this->registerJs("
    $(document).on('click', '.clickable-row', function() {
        window.location = $(this).data('url');
    });
");
    ?>

    <div class="row">
        <div class="col-lg-7">
            <a href="<?= Url::to(['index']) ?>" class="btn btn-primary btn-sm btnVoltar" style="margin: 20px 30px 40px 0">Voltar</a>
        </div>
    </div>

</div>
