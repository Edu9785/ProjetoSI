<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Metodoexpedicao $model */

$this->title = 'Editar Método de Expedição: ' . $model->id;

?>
<div class="metodoexpedicao-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
