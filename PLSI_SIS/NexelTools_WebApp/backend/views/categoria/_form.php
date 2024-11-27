<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Categoria $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="categoria-form">

    <?php $form = ActiveForm::begin([
            'options' => ['enctype' => 'multipart/form-data'],
    ]); ?>

    <?= $form->field($model, 'tipo')->textInput(['maxlength' => true])->label('Nome da Categoria: ') ?>

    <?= $form->field($model, 'imagemCat')->fileInput()->label('Imagem da categoria: ') ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
