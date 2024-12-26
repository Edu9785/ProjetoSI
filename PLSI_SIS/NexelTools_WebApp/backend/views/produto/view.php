<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Produto $model */

$this->title = $model->nome;
\yii\web\YiiAsset::register($this);
?>

<div class="produto-view">

    <p>
        <?= Html::a('Editar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Tem a certeza que quer eliminar este item?',
                'method' => 'post',
            ],
        ]) ?>
        <?php if($model->estado == \common\models\Produto::ENTREGUE): ?>
            <?= Html::a('Ver Avaliação', ['avaliacao/view', 'id_produto' => $model->id], ['class' => 'btn btn-warning']) ?>
        <?php endif; ?>
    </p>

    <div class="row">
        <div class="col-lg-7">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    [
                        'attribute' => 'Vendedor',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->profile->user->username;
                        },
                    ],
                    [
                        'attribute' => 'Preço',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->preco . '€';
                        },
                    ],
                    [
                        'attribute' => 'Descrição',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->desc;
                        },
                    ],
                    [
                        'attribute' => 'Categoria',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->categoria->tipo;
                        },
                    ],
                    [
                        'attribute' => 'Nome',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->nome;
                        },
                    ],
                    [
                        'attribute' => 'Estado',
                        'format' => 'raw',
                        'value' => function ($model) {
                            if ($model->estado == 0) {
                                return Html::encode("Disponível");
                            } elseif ($model->estado == 1) {
                                return Html::encode("Em entrega");
                            } else {
                                return Html::encode("Entregue");
                            }
                        },
                    ],
                ],
            ]) ?>
        </div>

        <!-- Carrossel de Imagens -->
        <div class="col-lg-5 d-flex align-items-center">
            <div id="product-carousel" class="carousel slide produto-img carousel-fade carousel-custom" data-ride="carousel" style="width: 300px; height: auto;">
                <div class="carousel-inner bg-light" style="max-height: 400px; max-width: 100%;">
                    <?php foreach ($imagemUrls as $index => $imagem): ?>
                        <div class="carousel-item <?= $index == 0 ? 'active' : '' ?>">
                            <img class="d-block w-100" src="<?= $imagem ?>" alt="Image">
                        </div>
                    <?php endforeach; ?>
                </div>
                <a class="carousel-control-prev" href="#product-carousel" data-slide="prev">
                    <i class="fa fa-2x fa-angle-left text-white"></i>
                </a>
                <a class="carousel-control-next" href="#product-carousel" data-slide="next">
                    <i class="fa fa-2x fa-angle-right text-white"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-7">
            <a href="<?= Url::to(['index']) ?>" class="btn btn-primary btn-sm btnVoltar" style="margin: 20px 30px 40px 0">Voltar</a>
        </div>
    </div>
</div>
