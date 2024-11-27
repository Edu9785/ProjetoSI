<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Profile $model */

$this->title = 'Editar Perfil: ' . $model->user->username;

?>
<div class="profile-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
