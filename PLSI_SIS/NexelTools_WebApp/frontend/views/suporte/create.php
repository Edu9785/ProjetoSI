<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Suporte $model */

$this->title = 'Suporte';

?>
<div class="suporte-create">

    <h1 class="section-title position-relative text-uppercase mb-4">
    <span class="bg-secondary pr-3">
        <?= Html::encode($this->title) ?>
    </span>
    </h1>

    <div class="row">
        <div class="col-md-7 suporteForm" style="margin-right: 20px;"> <!-- Espaço com margem -->
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>


        <div class="col-md-4 info">
            <div class="info-box bg-light p-3">
                <h3>Informações</h3>
                <div class="info-body">
                    <p>
                        <i class="fas fa-map-marker-alt" style="color: #ffcc00"></i>
                        Leiria, Portugal
                    </p>
                    <p>
                        <i class="fas fa-envelope" style="color: #ffcc00;"></i>
                        nexeltools@gmail.com
                    </p>
                    <p>
                        <i class="fas fa-phone-alt" style="color: #ffcc00"></i>
                        +351 923 456 783
                    </p>
                </div>
            </div>
        </div>

    </div>


</div>

