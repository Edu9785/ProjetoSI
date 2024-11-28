<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Categoria $model */

$this->title = 'Editar Categoria: ' . $model->tipo;

?>
<div class="categoria-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
