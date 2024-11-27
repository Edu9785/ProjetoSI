<?php

use common\models\Imagem;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Categoria $model */

$this->title = $model->tipo;
\yii\web\YiiAsset::register($this);
?>
<div class="categoria-view">


    <p>
        <?= Html::a('Update', ['Editar', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['Eliminar', 'id' => $model->id], [
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
            'tipo',
            [
                'attribute' => 'Imagem',
                'format' => 'raw',
                'value' => function ($model) {
                    if ($model->id_imagem) {
                        $imagem = Imagem::findOne($model->id_imagem);

                        if ($imagem) {
                            // Resolve o caminho absoluto no servidor
                            $path = Yii::getAlias($imagem->imagens);

                            // Verifica se o arquivo de imagem existe no servidor
                            if (file_exists($path)) {
                                // Ajusta o caminho para a URL pública
                                $urlImagem = Yii::getAlias($path);

                                // Exibe a imagem com a URL pública correta
                                return Html::img($urlImagem, ['alt' => 'Imagem', 'style' => 'width: 10px; height: auto;']);
                            } else {
                                return 'Imagem não encontrada';
                            }
                        }
                    }
                    return 'Sem imagem';
                },
            ],
        ],
    ]) ?>

</div>
