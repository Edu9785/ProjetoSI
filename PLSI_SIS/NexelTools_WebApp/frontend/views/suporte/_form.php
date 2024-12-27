<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Suporte $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="suporte-form">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'assunto')->textInput(['maxlength' => true])->label('Assunto') ?>

    <?= $form->field($model, 'desc')->textArea(['maxlength' => true, 'rows' => 8])->label('Descrição do problema') ?>

    <div class="form-group">
        <?= Html::submitButton('Enviar', ['class' => 'btn btn-success btnEnviar']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
