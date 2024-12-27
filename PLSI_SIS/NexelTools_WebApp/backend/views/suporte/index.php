<?php

use common\models\Suporte;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Mensagens';
?>
<div class="suporte-index">


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'attribute' => 'User',
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->profile->user->username;
                },
                'contentOptions' => ['class' => 'text-center'],
                'headerOptions' => ['class' => 'text-center'],
            ],
            [
                'attribute' => 'Nome',
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->assunto;
                },
                'contentOptions' => ['class' => 'text-center'],
                'headerOptions' => ['class' => 'text-center']
            ],
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Suporte $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                },
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        return Html::a(
                            '<i class="fas fa-eye"></i>',  // Ícone de visualização
                            $url,
                            [
                                'class' => 'btn btn-info btn-sm',  // Botão azul
                                'title' => 'Ver detalhes',
                            ]
                        );
                    },
                    'delete' => function ($url, $model, $key) {
                        return Html::a(
                            '<i class="fas fa-check"></i>',  // Ícone de exclusão
                            $url,
                            [
                                'class' => 'btn btn-success btn-sm',  // Botão verde (para deletar)
                                'title' => 'Excluir',
                                'data' => [
                                    'method' => 'post',
                                ],

                            ]
                        );
                    },
                ],
                'template' => '{view} {delete}',
                'contentOptions' => ['class' => 'text-center'],
            ],
        ],
    ]); ?>


</div>
