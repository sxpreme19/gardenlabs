<?php
/* @var $content string */

use yii\bootstrap4\Breadcrumbs;
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        <?php if($this->title == "Dashboard"): ?>
                            Welcome, <b><?= \yii\helpers\Html::encode(Yii::$app->user->identity->username) ?></b>!
                        <?php elseif($this->title == "Users"): ?>
                            User Management
                        <?php elseif($this->title == "Produtos"): ?>
                            Product Management
                        <?php elseif($this->title == "Create Produto"): ?>
                            <h5>Products with no images <strong>wont</strong> be displayed in the shop</h5>
                        <?php endif; ?>
                    </h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <?php
                    if($this->title != "Dashboard"):
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