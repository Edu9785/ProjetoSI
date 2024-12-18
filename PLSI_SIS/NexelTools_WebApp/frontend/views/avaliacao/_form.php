<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Avaliacao $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="avaliacao-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'avaliacao')->textInput(['maxlength' => true])->label('Avaliação(1-5)') ?>

    <?= $form->field($model, 'desc')->textarea(['maxlength' => true, 'rows' => 6, 'placeholder' => 'Escreva a sua mensagem aqui...'])->label('Comentário') ?>

    <div class="form-group">
        <?= Html::submitButton('Comentar', ['class' => 'btn btn-success btnComentar']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
