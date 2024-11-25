<?php

use common\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Gestão de utilizadores';
?>
<div class="user-index" style="padding: 30px">
    <div class="row">
        <?php foreach ($users as $user): ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">ID: <?= $user->id ?></h5><br>
                        <p class="card-text"><strong>Username:</strong> <?= $user->username ?></p>
                        <p class="card-text"><strong>Email:</strong> <?= $user->email ?></p>
                        <?php
                        $role = Yii::$app->authManager->getRolesByUser($user->id);
                        $funcao = !empty($role) ? key($role) : 'Sem função atribuída';
                        ?>
                        <p class="card-text"><strong>Função:</strong> <?= Html::encode($funcao) ?>

                        <div class="d-flex justify-content-between">
                            <a href="<?= Url::to(['view', 'id' => $user->id]) ?>" class="btn btn-primary btn-sm">Ver</a>

                            <?php if ($funcao == 'utilizador' || Yii::$app->user->id == $user->id): ?>
                                <a href="<?= Url::to(['update', 'id' => $user->id]) ?>" class="btn btn-warning btn-sm">Editar</a>
                            <?php endif; ?>

                            <a href="<?= Url::to(['delete', 'id' => $user->id]) ?>" data-method="post" data-confirm="Tem certeza que deseja eliminar este utilizador?" class="btn btn-danger btn-sm">Eliminar</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
