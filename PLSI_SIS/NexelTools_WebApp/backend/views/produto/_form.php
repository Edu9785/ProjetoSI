<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Produto $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="produto-form">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data'],
    ]); ?>

    <?= $form->field($model, 'nome')->textInput(['required' => true])->label('Nome:') ?>

    <?= $form->field($model, 'preco')->textInput(['required' => true])->label('Preço:') ?>

    <?= $form->field($model, 'desc')->textarea(['required' => true])->label('Descrição:') ?>

    <?= $form->field($model, 'id_tipo')->dropDownList($categorias, ['prompt' => 'Selecione uma Categoria', 'required' => true])->label('Categoria') ?>

    <?= $form->field($model, 'estado')->dropDownList([
        0 => 'Disponível',
        1 => 'Em entrega',
        2 => 'Entregue',
    ], ['prompt' => 'Selecione um estado']) ?>

    <?= $form->field($model, 'imagens[]')->fileInput(['multiple' => true])->label('Imagens: ') ?>


    <div class="form-group">
        <?= Html::submitButton('Confirmar', ['class' => 'btn btn-primary confirm-button'])  ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
