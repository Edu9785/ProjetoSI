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

                            if (file_exists($path)) {

                                $urlImagem = Yii::getAlias('@web') . str_replace('@common', 'uploads', $imagem->imagens);

                                return Html::img($urlImagem, ['alt' => 'Imagem', 'style' => 'width: 100%; height: auto;']);
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
