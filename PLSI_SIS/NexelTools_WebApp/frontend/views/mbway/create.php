<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Mbway $model */

$this->title = 'Create Mbway';
$this->params['breadcrumbs'][] = ['label' => 'Mbways', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mbway-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
