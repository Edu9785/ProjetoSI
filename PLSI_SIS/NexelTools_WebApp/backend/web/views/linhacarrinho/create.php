<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var frontend\models\Linhacarrinho $model */

$this->title = 'Create Linhacarrinho';
$this->params['breadcrumbs'][] = ['label' => 'Linhacarrinhos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="linhacarrinho-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
