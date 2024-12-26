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
                            'class' => ActionColumn::className(),
                            'template' => '{view}',
                            'buttons' => [
                                'view' => function ($url, $model, $key) {
                                    return Html::a('<i class="fa fa-eye"></i>', $url, [
                                        'class' => 'btn btn-info btn-sm',
                                        'style' => 'background-color: #007bff; color: white; border: none; padding: 5px 10px; border-radius: 4px;',
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
