<?php

use yii\helpers\Html;

?>
<div class="compra-create">

    <h1 class="section-title position-relative text-uppercase mb-4">
    <span class="bg-secondary pr-3">
        <?= Html::encode($this->title) ?>
    </span>
    </h1>

    <?= $this->render('_form', [
        'model' => $model,
        'profile' => $profile,
        'metodoexpedicoes' => $metodoexpedicoes,
        'metodopagamentos' => $metodopagamentos,
        'linhascarrinho' => $linhascarrinho,
        'carrinho' => $carrinho,
    ]) ?>

</div>
