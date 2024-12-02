<?php

use common\models\Categoria;
use common\models\Imagem;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Categorias';
?>
<div class="categoria-index">

    <p>
        <?= Html::a('Criar Categoria', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'attribute' => 'tipo',
                'headerOptions' => [
                    'style' => 'text-align: center;'
                ],
                'contentOptions' => [
                    'style' => 'text-align: center;'
                ],
            ],
            [
                'attribute' => 'Imagem',
                'format' => 'raw',
                'value' => function ($model) {
                    if ($model->id_imagem) {
                        $imagem = Imagem::findOne($model->id_imagem);

                        if ($imagem) {

                            $path = Yii::getAlias($imagem->imagens);

                            $urlImagem = Yii::getAlias('@web/uploads/') . basename($imagem->imagens);

                            if (file_exists($path)) {
                                return Html::img($urlImagem, ['alt' => 'Imagem', 'style' => 'width: 40px; height: auto;']);
                            } else {
                                return 'Imagem não encontrada';
                            }
                        }
                    }
                    return 'Sem imagem';
                },
                'headerOptions' => [
                    'style' => 'text-align: center;'
                ],
                'contentOptions' => [
                    'style' => 'text-align: center;'
                ],
            ],
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Categoria $model, $key, $index, $column) {
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
