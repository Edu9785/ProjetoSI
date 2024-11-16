<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


/** @var yii\web\View $this */
/** @var common\models\User $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="user-form">
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'username')->textInput() ?>
    <?= $form->field($model->profile, 'nome')->textInput() ?>
    <?= $form->field($model, 'email')->textInput() ?>
    <?= $form->field($model, 'status')->textInput() ?>
    <?= $form->field($model->profile, 'morada')->textInput() ?>
    <?= $form->field($model->profile, 'nif')->textInput() ?>
    <?= $form->field($model->profile, 'telemovel')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
