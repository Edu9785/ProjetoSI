<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Produto $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="container-produto">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data'],
    ]); ?>

    <?= $form->field($model, 'nome')->textInput()->label('Nome:') ?>

    <?= $form->field($model, 'preco')->textInput(['type' => 'number'])->label('Preço:') ?>

    <?= $form->field($model, 'desc')->textarea()->label('Descrição:') ?>

    <?= $form->field($model, 'id_tipo')->dropDownList($categorias, ['prompt' => 'Selecione uma Categoria'])->label('Categoria') ?>

    <?= $form->field($model, 'imagens[]')->fileInput(['multiple' => true]) ?>


    <div class="form-group">
        <?= Html::submitButton('Confirmar', ['class' => 'btn btn-primary confirm-button'])  ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
