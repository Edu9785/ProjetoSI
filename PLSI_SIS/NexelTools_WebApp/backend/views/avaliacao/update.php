<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Avaliacao $model */

$this->title = 'Editar Avaliação: ' . $model->produto->nome;

?>
<div class="avaliacao-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
