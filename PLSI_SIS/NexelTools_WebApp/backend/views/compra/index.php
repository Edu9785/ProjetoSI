            <?php

            use common\models\compra;
            use yii\helpers\Html;
            use yii\helpers\Url;
            use yii\grid\ActionColumn;
            use yii\grid\GridView;

            /** @var yii\web\View $this */
            /** @var yii\data\ActiveDataProvider $dataProvider */

            $this->title = 'Compras';
            ?>
            <div class="compra-index">

                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => [
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
                        [
                            'attribute' => 'Estado',
                            'format' => 'raw',
                            'value' => function ($model) {

                                $linhascompra = \common\models\Linhacompra::find()->where(['id_compra' => $model->id])->all();

                                $todosEntregues = true;

                                foreach ($linhascompra as $linha) {
                                    if ($linha->produto->estado == \common\models\Produto::EM_PROCESSAMENTO) {
                                        return 'Em processamento...';
                                    }
                                    if ($linha->produto->estado == \common\models\Produto::EM_ENTREGA) {
                                        $todosEntregues = false;
                                    }
                                }

                                if ($todosEntregues == false) {
                                    return 'Em entrega...';
                                }
                                return 'Entregue';
                            },
                        ],
                        [
                            'class' => ActionColumn::className(),
                            'template' => '{view} {enviar}',
                            'buttons' => [
                                'view' => function ($url, $model, $key) {
                                    return Html::a('<i class="fa fa-eye"></i>', $url, [
                                        'class' => 'btn btn-info btn-sm',
                                        'style' => 'background-color: #007bff; color: white; border: none; padding: 5px 10px; border-radius: 4px;',
                                    ]);
                                },
                                'enviar' => function ($url, $model, $key) {

                                    $produtosCompra = \common\models\Linhacompra::find()->where(['id_compra' => $model->id])->all();
                                    $todosEntregues = true;

                                    foreach ($produtosCompra as $produtoCompra) {
                                        if ($produtoCompra->produto->estado == \common\models\Produto::EM_PROCESSAMENTO) {
                                            return Html::a('<i class="fa fa-truck"></i>', $url, [
                                                'class' => 'btn btn-success btn-sm',
                                                'style' => 'background-color: #28a745; color: white; border: none; padding: 5px 10px; border-radius: 4px; margin-left: 15px;',
                                                'title' => 'Marcar como enviada',
                                                'data-confirm' => 'Tem certeza que pretende Enviar esta encomenda?',
                                                'data-method' => 'post',
                                            ]);
                                        }

                                        if ($produtoCompra->produto->estado == \common\models\Produto::EM_ENTREGA) {
                                            $todosEntregues = false;
                                        }

                                    }

                                    if ($todosEntregues == false) {
                                        return Html::tag('span', '<i class="fa fa-shipping-fast"></i>', [
                                            'class' => 'btn btn-sm',
                                            'style' => 'background-color: #ff9800; color: white; border: none; padding: 5px 10px; border-radius: 4px; margin-left: 15px; cursor: default;',
                                            'title' => 'Encomenda enviada',
                                        ]);
                                    }


                                    return Html::tag('span', '<i class="fa fa-check-circle"></i>', [
                                        'class' => 'btn btn-sm',
                                        'style' => 'background-color: green; color: white; border: none; padding: 5px 10px; border-radius: 4px; margin-left: 15px; cursor: default;',
                                        'title' => 'Encomenda entregue',
                                    ]);
                                },
                            ],
                            'urlCreator' => function ($action, compra $model, $key, $index, $column) {
                                return Url::toRoute([$action, 'id' => $model->id]);
                            }
                        ],
                        ],
                        'tableOptions' => [
                            'class' => 'table table-bordered table-hover',
                        ],
                        'headerRowOptions' => ['style' => 'background-color: #f8f9fa; text-align: center;'],
                        'rowOptions' => ['style' => 'text-align: center;'],
                    ]); ?>


            </div>
