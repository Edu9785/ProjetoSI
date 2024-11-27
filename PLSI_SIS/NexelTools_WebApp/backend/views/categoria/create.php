<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Categoria $model */

$this->title = 'Criar Categoria';
?>
<div class="categoria-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
