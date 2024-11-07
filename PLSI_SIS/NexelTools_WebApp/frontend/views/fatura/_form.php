<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Fatura $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="fatura-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'precofatura')->textInput() ?>

    <?= $form->field($model, 'datahora')->textInput() ?>

    <?= $form->field($model, 'id_profile')->textInput() ?>

    <?= $form->field($model, 'id_metodopagamento')->textInput() ?>

    <?= $form->field($model, 'id_expedicao')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
