<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <img src="<?= Yii::getAlias('@web') ?>/img/logo.png" alt="NexelTools Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Nexel Tools</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="info">
                <a href="#" class="d-block"><?= Yii::$app->user->identity->username ?>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <!-- href be escaped -->
        <!-- <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div> -->

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <?php
            echo \hail812\adminlte\widgets\Menu::widget([
                'items' => [
                    ['label' => 'Dashboard', 'url' => ['site/index'], 'icon' => 'fas fa-tachometer-alt'],
                    [
                        'label' => 'Páginas',
                        'icon' => 'fas fa-shopping-cart',
                        'items' => [
                            ['label' => 'Produtos', 'url' => ['produto/index'], 'iconStyle' => 'far'],
                            ['label' => 'Categorias', 'url' => ['categoria/index'], 'iconStyle' => 'far'],
                            ['label' => 'Métodos de Expedição', 'url' => ['metodoexpedicao/index'], 'iconStyle' => 'far'],
                            ['label' => 'Métodos de Pagamento', 'url' => ['metodopagamento/index'], 'iconStyle' => 'far'],
                        ]
                    ],
                    ['label' => 'Utilizadores', 'url' => ['user/index'], 'icon' => 'fas fa-user',],
                    ['label' => 'Histórico', 'url' => ['compra/index'], 'icon' => 'fas fa-history',],
                    ['label' => 'Suporte', 'url' => ['suporte/index'], 'icon' => 'fas fa-question-circle',],
                    ['label' => 'Yii2 Tools', 'header' => true],
                    ['label' => 'Login', 'url' => ['site/login'], 'icon' => 'sign-in-alt', 'visible' => Yii::$app->user->isGuest],
                    ['label' => 'Gii',  'icon' => 'file-code', 'url' => ['/gii'], 'target' => '_blank'],
                    ['label' => 'Debug', 'icon' => 'bug', 'url' => ['/debug'], 'target' => '_blank'],

                ],
            ]);
            ?>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>