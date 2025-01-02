<?php
use yii\helpers\Html;
use yii\web\View;
?>
<div class="corpo">
<div class="cartao">
    <div class="cartao-body login-card-body">
        <p class="login-box-msg">Admin Login</p>
        <?php $form = \yii\bootstrap4\ActiveForm::begin(['id' => 'login-form']) ?>
        <?php if (Yii::$app->session->hasFlash('error')): ?>
            <div class="alert alert-danger">
                <?= Yii::$app->session->getFlash('error') ?>
            </div>
        <?php endif; ?>
        <?= $form->field($model, 'username',  [
            'options' => ['class' => 'form-grupo txtusername'],
        ])
            ->label(false)
            ->textInput(['placeholder' => $model->getAttributeLabel('username')]) ?>

        <?= $form->field($model, 'password', [
            'options' => ['class' => 'form-grupo txtpassword'],
        ])
            ->label(false)
            ->passwordInput(['placeholder' => $model->getAttributeLabel('password')]) ?>

        <div class="row">
            <div class="col-12">
                <?= Html::submitButton('Login', ['class' => 'btn btn-primary btn-block btnAdminLogin']) ?>
            </div>
        </div>
        <div>
            <?= Html::a('Registar novo Administrador', ['site/signup'], ['class'=>'btnRegistarAdmin'])?>
        </div>

        <?php \yii\bootstrap4\ActiveForm::end(); ?>
    </div>
</div>
</div>