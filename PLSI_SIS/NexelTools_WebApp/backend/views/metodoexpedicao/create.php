<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Metodoexpedicao $model */

$this->title = 'Criar Métodos de Expedição';

?>
<div class="metodoexpedicao-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
