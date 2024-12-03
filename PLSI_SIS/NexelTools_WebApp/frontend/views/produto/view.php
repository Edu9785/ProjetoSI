<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\Models\Imagemproduto;
use common\Models\Imagem;

/** @var yii\web\View $this */
/** @var common\models\Produto $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Produtos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="produto-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>


    <?= DetailView::widget([

        'model' => $model,
        'attributes' => [
            'id',
            'id_vendedor',
            'desc',
            [
                    'attribute'=>'imagem',
                    'format' => 'raw',
                    'value' => function ($model) {
                    $imagemproduto = Imagemproduto::find()->where(['id_produto' => $model->id])->all();

                    if ($imagemproduto) {
                        foreach ($imagemproduto as $imagensProduto) {

                            $imagem = Imagem::findOne($imagensProduto->id_imagem);

                            if ($imagem) {
                                $path = Yii::getAlias('@backend/web/uploads/' . basename($imagem->imagens));
                                $urlImagem = Yii::getAlias('@uploadsUrl') . '/' . basename($imagem->imagens);

                                if (file_exists($path)) {
                                    Yii::error("path: " . $path);
                                    return Html::img($urlImagem, ['alt' => 'Imagem', 'style' => 'width: 40px; height: auto;']);
                                } else {
                                    return 'Imagem não encontrada';
                                }
                            }
                        }
                    }
                        return 'Sem imagem';
                },
            ],
            'preco',
            'id_tipo',
        ],
    ]) ?>

</div>
