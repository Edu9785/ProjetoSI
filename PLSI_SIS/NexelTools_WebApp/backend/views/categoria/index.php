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
            'tipo',
            [
                'attribute' => 'Imagem',
                'format' => 'raw',
                'value' => function ($model) {
                    if ($model->id_imagem) {
                        $imagem = Imagem::findOne($model->id_imagem);

                        if ($imagem) {

                            $path = Yii::getAlias($imagem->imagens);

                            $urlImagem = Yii::getAlias('@web/uploads') . '/' . basename($imagem->imagens);

                            if (file_exists($path)) {
                                return Html::img($urlImagem, ['alt' => 'Imagem', 'style' => 'width: 40px; height: auto;']);
                            } else {
                                return 'Imagem não encontrada';
                            }
                        }
                    }
                    return 'Sem imagem';
                },

            ],
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Categoria $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>




</div>
