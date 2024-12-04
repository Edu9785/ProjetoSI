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

    <p>
        <?= Html::a('Criar Produto', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <div class="produto-index">

        <div class="table-responsive bg-light p-4">
            <table class="table table-bordered table-hover">
                <thead class="thead-dark">
                <tr>
                    <th>Imagem</th>
                    <th>Nome</th>
                    <th>Preço (€)</th>
                    <th>Descrição</th>
                    <th>Ações</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($produtos as $produto): ?>
                    <tr>
                        <td>
                            <img src="<?= isset($imagemUrls[$produto->id]) ? $imagemUrls[$produto->id] : Yii::getAlias('@web') . '/images/default.jpg' ?>"
                                 alt="<?= Html::encode($produto->nome) ?>"
                                 style="width: 100px; height: auto;">

                        </td>
                        <td><?= Html::encode($produto->nome) ?></td>
                        <td><?= Html::encode($produto->preco) ?></td>
                        <td><?= Html::encode($produto->desc) ?></td>
                        <td style="text-align: center;">
                            <a href="<?= Url::to(['produto/view', 'id' => $produto->id]) ?>" class="btn btn-sm btn-primary" style="margin-right: 10px;">Ver</a>
                            <a href="<?= Url::to(['produto/update', 'id' => $produto->id]) ?>" class="btn btn-sm btn-warning" style="margin-right: 10px;">Editar</a>
                            <?= Html::a('Eliminar', ['produto/delete', 'id' => $produto->id], [
                                'class' => 'btn btn-sm btn-danger',
                                'data' => [
                                    'confirm' => 'Tem a certeza que deseja eliminar este produto?',
                                    'method' => 'post',
                                ],
                            ]) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
