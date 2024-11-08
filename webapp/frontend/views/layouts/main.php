<?php

/** @var \yii\web\View $this */
/** @var string $content */

use common\widgets\Alert;
use frontend\assets\AppAsset;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<!-- Start Main Top -->
<div class="main-top">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="custom-select-box">
                    <select id="basic" class="selectpicker show-tick form-control" data-placeholder="$ USD">
                        <option>¥ JPY</option>
                        <option>$ USD</option>
                        <option>€ EUR</option>
                    </select>
                </div>
                <div class="right-phone-box">
                    <p>Call US :- <a href="#"> +11 900 800 100</a></p>
                </div>
                <div class="our-link">
                    <ul>
                        <li><a href="#"><i class="fa fa-user s_color"></i> My Account</a></li>
                        <li><a href="#"><i class="fas fa-location-arrow"></i> Our location</a></li>
                        <li><a href="http://localhost/gardenlabs/apps/webapp/frontend/web/index.php?r=site%2Fcontact"><i class="fas fa-headset"></i> Contact Us</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="login-box">
                    <select id="basic" class="selectpicker show-tick form-control" data-placeholder="Sign In">
                        <option>Register Here</option>
                        <option>Sign In</option>
                    </select>
                </div>
                <div class="text-slid-box">
                    <div id="offer-box" class="carouselTicker">
                        <ul class="offer-box">
                            <li><i class="fab fa-opencart"></i> 20% off Entire Purchase Promo code: offT80</li>
                            <li><i class="fab fa-opencart"></i> 50% - 80% off on Vegetables</li>
                            <li><i class="fab fa-opencart"></i> Off 10%! Shop Vegetables</li>
                            <li><i class="fab fa-opencart"></i> Off 50%! Shop Now</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Main Top -->

<header class="main-header">
    <!-- Start Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light navbar-default bootsnav">
        <div class="container">
            <!-- Start Header Navigation -->
            <div class="navbar-header">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-menu" aria-controls="navbars-rs-food" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand" href="<?= Yii::$app->homeUrl ?>"><img src="images/logo-no-background.png" class="logo" alt="Logo" style="width: 150px; height: auto;"></a>
            </div>
            <!-- End Header Navigation -->

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="navbar-menu">
                <?php
                echo Nav::widget([
                    'options' => ['class' => 'navbar-nav ml-auto'],
                    'items' => [
                        ['label' => 'Home', 'url' => ['/site/index'], 'options' => ['class' => 'nav-item']],
                        ['label' => 'About Us', 'url' => ['/site/about'], 'options' => ['class' => 'nav-item']],
                        [
                            'label' => 'SHOP',
                            'url' => '#',
                            'options' => ['class' => 'nav-item dropdown'],
                            'linkOptions' => [
                                'class' => 'nav-link dropdown-toggle',
                                'data-toggle' => 'dropdown',
                            ],
                            'items' => [
                                ['label' => 'Sidebar Shop', 'url' => ['/site/sidebar-shop']],
                                ['label' => 'Shop Detail', 'url' => ['/site/shop-detail']],
                                ['label' => 'Cart', 'url' => ['/site/cart']],
                                ['label' => 'Checkout', 'url' => ['/site/checkout']],
                                ['label' => 'My Account', 'url' => ['/site/my-account']],
                                ['label' => 'Wishlist', 'url' => ['/site/wishlist']],
                            ],
                        ],
                        ['label' => 'Gallery', 'url' => ['/site/gallery'], 'options' => ['class' => 'nav-item']],
                        ['label' => 'Contact Us', 'url' => ['/site/contact'], 'options' => ['class' => 'nav-item']],
                    ],
                ]);
                ?>
            </div>

            <!-- Start Atribute Navigation -->
            <div class="attr-nav">
                <ul>
                    <li class="search"><a href="#"><i class="fa fa-search"></i></a></li>
                    <li class="side-menu">
                        <a href="#">
                            <i class="fa fa-shopping-bag"></i>
                            <span class="badge">3</span>
                            <p>My Cart</p>
                        </a>
                    </li>
                </ul>
            </div>
            <!-- End Atribute Navigation -->
        </div>
    </nav>
    <!-- End Navigation -->
</header>
   <!-- Start Top Search -->
   <div class="top-search">
        <div class="container">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-search"></i></span>
                <input type="text" class="form-control" placeholder="Search">
                <span class="input-group-addon close-search"><i class="fa fa-times"></i></span>
            </div>
        </div>
    </div>
    <!-- End Top Search -->


<main role="main" class="flex-shrink-0">
    <div class="container-fluid">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</main>

<footer class="footer mt-auto py-3 text-muted">
    <div class="container-fluid">
        <p class="float-start">&copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?></p>
        <p class="float-end"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage();
