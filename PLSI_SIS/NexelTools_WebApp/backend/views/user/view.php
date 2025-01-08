<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var common\models\User $model */

$this->title = "Utilizador ID:" . $model->id;
\yii\web\YiiAsset::register($this);

$isAdmin = Yii::$app->authManager->getAssignment('admin', $model->id);
?>
<div class="user-view">
    <div class="user-view">
        <?php if (Yii::$app->session->hasFlash('success')): ?>
            <div class="alert alert-success">
                <?= Yii::$app->session->getFlash('success') ?>
            </div>
        <?php endif; ?>

        <?php if (Yii::$app->session->hasFlash('error')): ?>
            <div class="alert alert-danger">
                <?= Yii::$app->session->getFlash('error') ?>
            </div>
        <?php endif; ?>

        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="card">
                    <div class="card-header text-center">
                        <h3>Detalhes do Utilizador</h3>
                    </div>
                    <div class="card-body">
                        <dl class="row">
                            <dt class="col-sm-3">Username:</dt>
                            <dd class="col-sm-9"><?= Html::encode($model->username) ?></dd>

                            <dt class="col-sm-3">Email:</dt>
                            <dd class="col-sm-9"><?= Html::encode($model->email) ?></dd>

                            <?php  if (!$isAdmin): // Apenas para utilizadores ?>
                            <dt class="col-sm-3">Nome:</dt>
                            <dd class="col-sm-9"><?= Html::encode($model->profile->nome) ?></dd>

                            <dt class="col-sm-3">Morada:</dt>
                            <dd class="col-sm-9"><?= Html::encode($model->profile->morada) ?></dd>

                            <dt class="col-sm-3">NIF:</dt>
                            <dd class="col-sm-9"><?= Html::encode($model->profile->nif) ?></dd>

                            <dt class="col-sm-3">Telemóvel:</dt>
                            <dd class="col-sm-9"><?= Html::encode($model->profile->telemovel) ?></dd>

                            <?php endif; ?>

                            <dt class="col-sm-3">Função:</dt>
                            <dd class="col-sm-9"><?= Html::encode(Yii::$app->authManager->getRolesByUser($model->id) ? key(Yii::$app->authManager->getRolesByUser($model->id)) : 'Sem função atribuída') ?></dd>

                        </dl>

                        <div class="d-flex justify-content-between">
                            <?= Html::a('Editar', ['update', 'id' => $model->id], ['class' => 'btn btn-warning btn-sm custom-btn']) ?>
                            <?= Html::a('Eliminar', ['delete', 'id' => $model->id], [
                                'class' => 'btn btn-danger btn-sm custom-btn',
                                'data' => [
                                    'method' => 'post',
                                    'confirm' => 'Tem certeza que deseja eliminar este utilizador?',
                                ]
                            ]) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <a href="<?= Url::to(['index']) ?>" class="btn btn-primary btn-sm btnVoltar" style="margin-left:320px">Voltar</a>
    </div>

</div>
