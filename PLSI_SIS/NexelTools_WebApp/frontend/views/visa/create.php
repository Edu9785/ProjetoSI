<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Visa $model */

$this->title = 'Create Visa';
$this->params['breadcrumbs'][] = ['label' => 'Visas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="visa-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
