<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Mbway $model */

$this->title = 'Update Mbway: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Mbways', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="mbway-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
