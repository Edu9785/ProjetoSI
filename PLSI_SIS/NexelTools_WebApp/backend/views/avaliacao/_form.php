<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Avaliacao $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="avaliacao-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_user')->textInput() ?>

    <?= $form->field($model, 'desc')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'avaliacao')->textInput() ?>

    <?= $form->field($model, 'id_produto')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
