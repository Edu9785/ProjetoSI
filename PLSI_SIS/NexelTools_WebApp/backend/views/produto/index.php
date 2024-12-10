<?php

use common\models\Produto;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Produtos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="produto-index">

    <div class="produto-index">
        <div class="row">
            <?php foreach ($produtos as $produto): ?>
                <div class="col-lg-3 col-md-4 col-sm-6 pb-3">
                    <div class="product-item bg-light mb-3" style="border: 1px solid #ddd; border-radius: 8px;">
                        <div class="product-img position-relative overflow-hidden">
                            <img class="img-fluid w-100 h-100"
                                 src="<?= $imagemUrls[$produto->id] ?>"
                                 alt="<?= Html::encode($produto->nome) ?>"
                                 style="object-fit: cover;">
                        </div>
                        <div class="text-center py-3 px-2">
                            <h6 class="h6 text-decoration-none text-truncate d-block mb-2"><?= Html::encode($produto->nome) ?></h6>
                            <h6><?= Html::encode($produto->preco . '€') ?></h6>
                            <h6><?= Html::encode('Vendedor: ' . $produto->profile->user->username) ?></h6>
                        </div>
                        <div class="card-footer text-center py-2">
                            <a href="<?= Url::to(['produto/view', 'id' => $produto->id]) ?>" class="btn btn-primary btn-sm">Ver</a>
                            <a href="<?= Url::to(['produto/update', 'id' => $produto->id]) ?>" class="btn btn-warning btn-sm">Editar</a>
                            <?= Html::a('Eliminar', ['produto/delete', 'id' => $produto->id], [
                                'class' => 'btn btn-danger btn-sm',
                                'data' => [
                                    'confirm' => 'Tem a certeza que deseja eliminar este produto?',
                                    'method' => 'post',
                                ],
                            ]) ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
