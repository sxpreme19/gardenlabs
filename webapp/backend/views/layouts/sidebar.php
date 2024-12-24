<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?=\yii\helpers\Url::to(['site/index'])?>" class="brand-link">
        <img src="<?=$assetDir?>/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">GardenLabs</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?=$assetDir?>/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block"><?= Yii::$app->user->identity->username?></a>
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
                    ['label' => 'Management', 'header' => true],
                    [
                        'label' => 'Dashboard',
                        'icon' => 'tachometer-alt',
                        'badge' => '<span class="right badge badge-info">2</span>',
                        'url' => ['site/index'],
                        /*'items' => [
                            ['label' => 'Active Page', 'url' => ['site/index'], 'iconStyle' => 'far'],
                            ['label' => 'Inactive Page', 'iconStyle' => 'far'],
                        ]*/
                    ],
                    [
                        'label' => 'User Control',
                        'icon' => 'user', 
                        'badge' => '<span class="right badge badge-danger">Admin</span>',
                        'items' => [
                            ['label' => 'Users', 'icon' => 'fas fa-user','url' => ['user/index']],
                            ['label' => 'User Profiles', 'icon' => 'fas fa-user','url' => ['userprofile/index']],
                        ],
                    ],
                    ['label' => 'Shopping Management', 'header' => true],
                    [
                        'label' => 'Shopping',
                        'icon' => 'fas fa-tags',
                        'items' => [
                            ['label' => 'Products', 'icon' => 'fas fa-box','url' => ['produto/index']],
                            ['label' => 'Services', 'icon' => 'fas fa-concierge-bell','url' => ['servico/index']],
                            ['label' => 'Wishlists', 'icon' => 'fas fa-heart', 'url' => ['favorito/index']],
                            ['label' => 'Reviews', 'icon' => 'fas fa-star', 'url' => ['review/index']],
                        ],
                    ],
                    [
                        'label' => 'Product Details',
                        'icon' => 'fas fa-list',
                        'items' => [
                            ['label' => 'Categories', 'icon' => 'fas fa-layer-group','url' => ['categoria/index']],
                            ['label' => 'Suppliers', 'icon' => 'fas fa-parachute-box','url' => ['fornecedor/index']],
                            ['label' => 'Images', 'icon' => 'fas fa-image','url' => ['imagem/index']],
                        ],
                    ],
                    [
                        'label' => 'Carts',
                        'icon' => 'fas fa-shopping-cart',
                        'items' => [
                            ['label' => 'User Product Carts', 'icon' => 'fas fa-shopping-basket', 'url' => ['carrinhoproduto/index']],
                            ['label' => 'User Service Carts', 'icon' => 'fas fa-cart-arrow-down', 'url' => ['carrinhoservico/index']],
                        ],
                    ],
                    [
                        'label' => 'Order Details',
                        'icon' => 'fas fa-receipt',
                        'badge' => '<span class="right badge badge-danger">Admin</span>',
                        'items' => [
                            ['label' => 'Invoices', 'icon' => 'fas fa-file-invoice-dollar', 'url' => ['fatura/index']],
                            ['label' => 'Expedition Methods', 'icon' => 'fas fa-shipping-fast','url' => ['metodoexpedicao/index']],
                            ['label' => 'Payment Methods', 'icon' => 'fas fa-credit-card','url' => ['metodopagamento/index']],
                        ],
                    ],
                    ['label' => 'Yii2 PROVIDED', 'header' => true],
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