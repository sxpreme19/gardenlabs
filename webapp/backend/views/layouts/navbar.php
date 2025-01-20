<?php

use yii\helpers\Html;

?>
<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="<?= \yii\helpers\Url::to(['site/index']) ?>" class="nav-link">Home</a>
        </li>
        <li class="nav-item dropdown">
            <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">User Control</a>
            <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">

                <li><a href="<?= \yii\helpers\Url::to(['user/index']) ?>" class="dropdown-item">Users</a></li>
                <li><a href="<?= \yii\helpers\Url::to(['userprofile/index']) ?>" class="dropdown-item">User Profiles</a></li>
            </ul>
        </li>
        <li class="nav-item dropdown">
            <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Shopping Management</a>
            <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                <li class="dropdown-submenu dropdown-hover">
                    <a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">Shopping</a>
                    <ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
                        <li><a href="<?= \yii\helpers\Url::to(['produto/index']) ?>" class="dropdown-item">Products</a></li>
                        <li><a href="<?= \yii\helpers\Url::to(['servico/index']) ?>" class="dropdown-item">Services</a></li>
                        <li><a href="<?= \yii\helpers\Url::to(['favorito/index']) ?>" class="dropdown-item">Wishlists</a></li>
                        <li><a href="<?= \yii\helpers\Url::to(['review/index']) ?>" class="dropdown-item">Reviews</a></li>
                    </ul>
                </li>
                <li class="dropdown-submenu dropdown-hover">
                    <a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">Product Details</a>
                    <ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
                        <li><a href="<?= \yii\helpers\Url::to(['categoria/index']) ?>" class="dropdown-item">Categories</a></li>
                        <li><a href="<?= \yii\helpers\Url::to(['fornecedor/index']) ?>" class="dropdown-item">Suppliers</a></li>
                        <li><a href="<?= \yii\helpers\Url::to(['imagem/index']) ?>" class="dropdown-item">Images</a></li>
                    </ul>
                </li>
            </ul>
        </li>
        <li class="nav-item dropdown">
            <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Cart Management</a>
            <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                <li class="dropdown-submenu dropdown-hover">
                    <a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">Carts</a>
                    <ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
                        <li><a href="<?= \yii\helpers\Url::to(['carrinhoproduto/index']) ?>" class="dropdown-item">Product Carts</a></li>
                        <li><a href="<?= \yii\helpers\Url::to(['carrinhoservico/index']) ?>" class="dropdown-item">Service Carts</a></li>

                    </ul>
                </li>
                <li class="dropdown-submenu dropdown-hover">
                    <a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">Cart Lines</a>
                    <ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
                        <li><a href="<?= \yii\helpers\Url::to(['linhacarrinhoproduto/index']) ?>" class="dropdown-item">Product Cart Lines</a></li>
                        <li><a href="<?= \yii\helpers\Url::to(['linhacarrinhoservico/index']) ?>" class="dropdown-item">Service Cart Lines</a></li>
                    </ul>
                </li>
            </ul>
        </li>
        <li class="nav-item dropdown">
            <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Order Management</a>
            <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                <li><a href="<?= \yii\helpers\Url::to(['fatura/index']) ?>" class="dropdown-item">Invoices</a></li>
                <li><a href="<?= \yii\helpers\Url::to(['linhafatura/index']) ?>" class="dropdown-item">Invoice Lines</a></li>
                <li><a href="<?= \yii\helpers\Url::to(['metodoexpedicao/index']) ?>" class="dropdown-item">Expedition Methods</a></li>
                <li><a href="<?= \yii\helpers\Url::to(['metodopagamento/index']) ?>" class="dropdown-item">Payment Methods</a></li>
            </ul>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <?= Html::a('<i class="fas fa-sign-out-alt"></i>', ['/site/logout'], ['data-method' => 'post', 'class' => 'nav-link']) ?>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                <i class="fas fa-th-large"></i>
            </a>
        </li>
    </ul>
</nav>
<!-- /.navbar -->