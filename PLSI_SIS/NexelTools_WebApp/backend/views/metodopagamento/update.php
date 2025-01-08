<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Metodopagamento $model */

$this->title = 'Editar ' . $model->nomemetodo;

?>
<div class="metodopagamento-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
