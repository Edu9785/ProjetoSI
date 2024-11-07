<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var frontend\models\Carrinhocompra $model */

$this->title = 'Update Carrinhocompra: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Carrinhocompras', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="carrinhocompra-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
