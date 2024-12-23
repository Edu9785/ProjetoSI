<?php
$this->title = 'Home';
$this->params['breadcrumbs'] = [['label' => $this->title]];
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-6">
            <?= \hail812\adminlte\widgets\Alert::widget([
                'type' => 'success',
                'body' => '<h3>Bem-vindo!</h3>',
            ]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
            <?= \hail812\adminlte\widgets\SmallBox::widget([
                'title' => $produtospublicados,
                'text' => '<strong>Novos Produtos</strong><br>Últimas 24H',
                'icon' => 'fas fa-box',
            ]) ?>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
            <?= \hail812\adminlte\widgets\SmallBox::widget([
                'title' => $produtosvendidos,
                'text' => '<strong>Produtos Vendidos</strong><br>Últimas 24H',
                'icon' => 'fas fa-cart-arrow-down',
            ]) ?>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
            <?= \hail812\adminlte\widgets\SmallBox::widget([
                'title' => $usersRecentes,
                'text' => '<strong>Novos Utilizadores</strong><br>Últimas 24H',
                'icon' => 'fas fa-user-plus',
            ]) ?>
        </div>


    </div>
</div>