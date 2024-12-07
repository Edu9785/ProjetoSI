<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var frontend\models\Linhacarrinho $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="linhacarrinho-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_carrinho')->textInput() ?>

    <?= $form->field($model, 'id_produto')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
