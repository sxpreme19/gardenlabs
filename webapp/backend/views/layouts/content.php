<?php
/* @var $content string */

use yii\bootstrap4\Breadcrumbs;
?>
<div class="content-wrapper">
    <?php foreach (Yii::$app->session->getAllFlashes() as $type => $message): ?>
        <?php
        $alertTypes = [
            'success' => 'alert-success',
            'error' => 'alert-danger',
            'warning' => 'alert-warning',
            'info' => 'alert-info',
        ];
        $alertClass = $alertTypes[$type] ?? 'alert-info';
        ?>
        <div class="alert <?= $alertClass ?> alert-dismissible fade show d-flex align-items-center" role="alert">
            <div class="flex-grow-1">
                <?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="margin-top: -2px;"></button>
        </div>
    <?php endforeach; ?>

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        <?php if ($this->title == "Dashboard"): ?>
                            Welcome, <b><?= \yii\helpers\Html::encode(Yii::$app->user->identity->username) ?></b>!
                        <?php elseif ($this->title == "Users"): ?>
                            User Management
                        <?php elseif ($this->title == "User Profiles"): ?>
                            User Profile Management
                        <?php elseif ($this->title == "Produtos"): ?>
                            Product Management
                        <?php elseif ($this->title == "Create Produto"): ?>
                            <h5>Products with no images <strong>wont</strong> be displayed in the shop</h5>
                        <?php elseif ($this->title == "Services"): ?>
                            Services Management
                        <?php elseif ($this->title == "Wishlists"): ?>
                            Wishlist Management
                        <?php elseif ($this->title == "Reviews"): ?>
                            Review Management
                        <?php elseif ($this->title == "Categories"): ?>
                            Category Management
                        <?php elseif ($this->title == "Suppliers"): ?>
                            Supplier Management
                        <?php elseif ($this->title == "Images"): ?>
                            Image Management
                        <?php elseif ($this->title == "Product Carts"): ?>
                            Product Cart Management
                        <?php elseif ($this->title == "Product Cart Lines"): ?>
                            Product Carts Line Management
                        <?php elseif ($this->title == "Service Carts"): ?>
                            Service Cart Management
                        <?php elseif ($this->title == "Service Carts Lines"): ?>
                            Service Carts Line Management
                        <?php elseif ($this->title == "Invoices"): ?>
                            Invoice Management
                        <?php elseif ($this->title == "Invoice Lines"): ?>
                            Invoice Line Management
                        <?php elseif ($this->title == "Expedition Methods"): ?>
                            Expedition Method Management
                        <?php elseif ($this->title == "Payment Methods"): ?>
                            Payment Method Management
                        <?php endif; ?>
                    </h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <?php
                    if ($this->title != "Dashboard"):
                        echo Breadcrumbs::widget([
                            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                            'options' => [
                                'class' => 'breadcrumb float-sm-right'
                            ]
                        ]);
                    endif;
                    ?>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <?= $content ?><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>