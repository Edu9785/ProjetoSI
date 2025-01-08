<?php

use common\models\Metodopagamento;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Metodos de pagamento';
?>
<div class="metodopagamento-index">

    <p>
        <?= Html::a('Criar Método', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'attribute' => 'nomemetodo',
                'label' => 'Método de pagamento',

                'headerOptions' => [
                    'style' => 'text-align: center;'
                ],
                'contentOptions' => [
                    'style' => 'text-align: center;'
                ],
            ],
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Metodopagamento $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                },
                'template' => '{view} {update} {delete}',
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        return Html::a('<i class="fas fa-eye"></i>', $url, [
                            'title' => 'Ver',
                            'class' => 'btn btn-sm btn-info',
                            'style' => 'margin-right: 20px;',
                        ]);
                    },
                    'update' => function ($url, $model, $key) {
                        return Html::a('<i class="fas fa-edit"></i>', $url, [
                            'title' => 'Editar',
                            'class' => 'btn btn-sm btn-warning',
                            'style' => 'margin-right: 20px;',
                        ]);
                    },
                    'delete' => function ($url, $model, $key) {
                        return Html::a('<i class="fas fa-trash"></i>', $url, [
                            'title' => 'Eliminar',
                            'class' => 'btn btn-sm btn-danger',
                            'style' => 'margin-right: 20px;',
                            'data-confirm' => 'Tem certeza que deseja eliminar este item?',
                            'data-method' => 'post',
                        ]);
                    },

                ],
                'headerOptions' => [
                    'style' => 'text-align: center;'
                ],
                'contentOptions' => [
                    'style' => 'text-align: center;'
                ],

            ],
        ],
    ]); ?>


</div>
