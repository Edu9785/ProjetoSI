<?php

use common\models\Metodoexpedicao;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Métodos de Expedições';
?>
<div class="metodoexpedicao-index">

    <?php if (Yii::$app->user->can('addShippingMethods')): ?>
        <p>
            <?= Html::a('Criar Método de Expedição', ['create'], ['class' => 'btn btn-success btnAddMetodoExp']) ?>
        </p>
    <?php else: ?>
        <p>Não tem permissão para criar métodos de expedição.</p>
    <?php endif; ?>

    <div class="ExpedicoesContainer">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Preço</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($metodosExpedicao as $metodo): ?>
                <tr class="metodo-item">
                    <td><?= Html::encode($metodo->nome) ?></td>
                    <td><?= Html::encode($metodo->preco . '€') ?></td>
                    <td>
                        <?= Html::a('Ver', ['view', 'id' => $metodo->id], ['class' => 'btn btn-primary btn-sm']) ?>
                        <?= Html::a('Editar', ['update', 'id' => $metodo->id], ['class' => 'btn btn-warning btn-sm']) ?>
                        <?= Html::a('Eliminar', ['view', 'id' => $metodo->id], [
                                'class' => 'btn btn-danger btn-sm',
                                'data' => [
                                        'confirm' => 'Pretende Eliminar este item?',
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
