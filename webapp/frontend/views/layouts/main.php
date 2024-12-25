<?php

/** @var \yii\web\View $this */
/** @var string $content */

use common\models\Carrinhoproduto;
use yii\helpers\Url;
use common\widgets\Alert;
use frontend\assets\AppAsset;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;

AppAsset::register($this);


if (!Yii::$app->user->isGuest) {
    $userCart = Carrinhoproduto::findOne(['userprofile_id' => Yii::$app->user->identity->userProfile->id]);
    $totalUserCartLines = count($userCart->linhacarrinhoprodutos);
}
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="shortcut icon" href="logo.ico" type="image/x-icon">
    <link rel="apple-touch-icon" href="logo.ico">

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Site Metas -->
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">

    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>

    <style>
        #search-results {
            position: absolute;
            z-index: 1000;
            max-height: 300px;
            display: block !important;
            overflow-y: auto;
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        #search-results li {
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }

        #search-results li a {
            color: #000;
            text-decoration: none;
        }
    </style>
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
                            <option>€ EUR</option>
                        </select>
                    </div>
                    <div class="right-phone-box">
                        <p>Call US :- <a href="#"> +351 223 126 221</a></p>
                    </div>
                    <div class="our-link">
                        <ul>
                            <li><a href="<?= \yii\helpers\Url::to(['produto/gallery']) ?>"><i class="fas fa-image"></i> Gallery</a></li>
                            <li><a href="<?= \yii\helpers\Url::to(['user/index']) ?>"><i class="fa fa-user s_color"></i> My Account</a></li>
                            <li><a href="<?= \yii\helpers\Url::to(['site/contact']) ?>"><i class="fas fa-headset"></i> Contact Us</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="login-box">
                        <?php if (Yii::$app->user->isGuest): ?>
                            <a href="<?= \yii\helpers\Url::to(['site/login']) ?>" class="btn btn-success">Login</a>
                        <?php else: ?>
                            <a href="<?= \yii\helpers\Url::to(['site/logout']) ?>" class="btn btn-danger" data-method="post">Logout</a>
                        <?php endif; ?>
                    </div>
                    <div class="text-slid-box">
                        <div id="offer-box" class="carouselTicker">
                            <ul class="offer-box">
                                <li><i class="fas fa-certificate"></i> New Arrivals! Check out our latest products!</li>
                                <li><i class="fas fa-comment-dots"></i> See Why Our Customers Love Our Products!</li>
                                <li><i class="fas fa-sync-alt"></i> Our Best-Sellers Are Back in Stock – Shop Now!</li>
                                <li><i class="fas fa-credit-card"></i> Pay Easily with Multiple Payment Options!</li>
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
                                    ['label' => 'Product Shop', 'url' => ['/produto/index']],
                                    ['label' => 'Cart', 'url' => ['/carrinhoproduto/index']],
                                    ['label' => 'My Account', 'url' => ['/user/index']],
                                    ['label' => 'Wishlist', 'url' => ['/favorito/index']],
                                ],
                            ],
                            ['label' => 'Gallery', 'url' => ['/produto/gallery'], 'options' => ['class' => 'nav-item']],
                            ['label' => 'Contact Us', 'url' => ['/site/contact'], 'options' => ['class' => 'nav-item']],
                        ],
                    ]);
                    ?>
                </div>
                <?php if (!Yii::$app->user->isGuest): ?>
                    <!-- Start Atribute Navigation -->
                    <div class="attr-nav">
                        <ul>
                            <li class="search"><a href="#"><i class="fa fa-search"></i></a></li>
                            <li class="side-menu">
                                <a href="#">
                                    <i class="fa fa-shopping-bag"></i>
                                    <span class="badge" style="color:black"><?= $totalUserCartLines ?></span>
                                    <p>My Cart</p>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <!-- End Atribute Navigation -->
            </div>
            <!-- Start Side Menu -->
            <div class="side">
                <a href="#" class="close-side"><i class="fa fa-times"></i></a>
                <li class="cart-box">
                    <ul class="cart-list">
                        <?php if (!empty($userCart->linhacarrinhoprodutos)): ?>
                            <?php foreach ($userCart->linhacarrinhoprodutos as $linhacarrinho): ?>
                                <?php if (!empty($linhacarrinho->produto)):
                                    $produto = $linhacarrinho->produto;
                                    if (!empty($produto->imagems)) {
                                        $productImages = $produto->imagems;
                                        $firstImage = null;
                                        if (!empty($productImages)) {
                                            $firstImage = $productImages[0];
                                        }
                                    }
                                ?>
                                    <li>
                                        <a href="<?= yii\helpers\Url::to(['produto/product-details', 'id' => $produto->id]) ?>" class="photo">
                                            <?php if (!empty($firstImage)): ?>
                                                <img src="<?= yii\helpers\Url::to('../../backend/web/uploads/' . $firstImage->filename) ?>" class="cart-thumb" title="<?= $produto->nome ?>" />
                                            <?php endif; ?>
                                        </a>
                                        <h6><a href="<?= yii\helpers\Url::to(['produto/product-details', 'id' => $produto->id]) ?>"><?= $produto->nome ?></a></h6>
                                        <p><?= $linhacarrinho->quantidade ?>x -
                                            <span class="price"><?= $produto->preco ?>€</span>
                                        </p>
                                    </li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                            <li class="total">
                                <a href="<?= yii\helpers\Url::to(['carrinhoproduto/index']) ?>" class="btn btn-default hvr-hover btn-cart">VIEW CART</a>
                                <span class="float-right"><strong>Total</strong>: <?= $userCart->total ?>€</span>
                            </li>
                        <?php else: ?>
                            <li>
                                <p>Your cart is empty.</p>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>
            </div>
            <!-- End Side Menu -->
        <?php endif; ?>
        </nav>
        <!-- End Navigation -->
    </header>
    <!-- Start Top Search -->
    <div class="top-search">
        <div class="container">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-search"></i></span>
                <input type="text" id="search-input" class="form-control" placeholder="Search" onkeyup="searchProducts(this.value)">
                <span class="input-group-addon close-search"><i class="fa fa-times"></i></span>
            </div>
            <ul class="dropdown-menu" id="search-results" style="display: none; position: absolute; width: 100%;"></ul>
        </div>
    </div>
    <!-- End Top Search -->

    <?php if (isset($this->title) && $this->title != 'Home'): ?>
        <!-- Start All Title Box -->
        <div class="all-title-box">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <h2><?= Html::encode($this->title) ?></h2>
                        <ul class="breadcrumb">
                            <?php if (isset($this->params['breadcrumbs']) && is_array($this->params['breadcrumbs'])): ?>
                                <?php foreach ($this->params['breadcrumbs'] as $breadcrumb): ?>
                                    <li class="breadcrumb-item <?= isset($breadcrumb['url']) ? '' : 'active' ?>">
                                        <?php if (isset($breadcrumb['url'])): ?>
                                            <a href="<?= Url::to($breadcrumb['url']) ?>"><?= Html::encode($breadcrumb['label']) ?></a>
                                        <?php else: ?>
                                            <?= Html::encode($breadcrumb['label']) ?>
                                        <?php endif; ?>
                                    </li>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- End All Title Box -->

    <main role="main" class="flex-shrink-0">
        <div class="container-fluid">
            <?= Alert::widget() ?>
            <?= $content ?>
        </div>
    </main>

    <!-- Start Footer  -->
    <footer>
        <div class="footer-main">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-md-12 col-sm-12">
                        <div class="footer-widget">
                            <h4>About GardenLabs</h4>
                            <p>GardenLabs is a leading company in the field of sustainable gardening and landscaping. Our team of experts is committed to providing innovative solutions that help our clients create beautiful and eco-friendly outdoor spaces. We combine cutting-edge technology with natural designs to bring the best of nature into your home.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12 col-sm-12">
                        <div class="footer-link-contact">
                            <h4>Contact Us</h4>
                            <ul>
                                <li>
                                    <p><i class="fas fa-map-marker-alt"></i>Address: Av. Combatentes da Grande Guerra<br>Leiria<br> 2400-122 </p>
                                </li>
                                <li>
                                    <p><i class="fas fa-phone-square"></i>Phone: <a href="tel:+1-888705770">+351 223 126 221</a></p>
                                </li>
                                <li>
                                    <p><i class="fas fa-envelope"></i>Email: <a href="mailto:gardenlabs.info@gmail.com">gardenlabs.info@gmail.com</a></p>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12 col-sm-12">
                        <div class="footer-widget">
                            <h4>Business Time</h4>
                            <ul class="list-time">
                                <li style="color:#cccccc;">Monday - Friday: 08.00am to 05.00pm</li>
                                <li style="color:#cccccc;">Saturday: 10.00am to 08.00pm</li>
                                <li style="color:#cccccc">Sunday: <span>Closed</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Start copyright
            <div class="footer-copyright">
                <p class="footer-company">All Rights Reserved. &copy; 2018 <a href="#">ThewayShop</a> Design By :
                    <a href="https://html.design/">html design</a>
                </p>
            </div>
            -->
            <a href="#" id="back-to-top" title="Back to top" style="display: none;">&uarr;</a>
        </div>
    </footer>
    <!-- End Footer  -->



    <?php $this->endBody() ?>
</body>
<script>
    let debounceTimeout;

    function searchProducts(query) {
        clearTimeout(debounceTimeout);

        if (!query.trim()) {
            const resultContainer = document.getElementById("search-results");
            resultContainer.style.display = "none";
            return;
        }

        debounceTimeout = setTimeout(() => {
            const newUrl = `/gardenlabs/webapp/frontend/web/index.php?r=produto/search&q=${encodeURIComponent(query)}`;
            window.history.pushState({
                path: newUrl
            }, '', newUrl);

            fetch(newUrl)
                .then(response => response.json())
                .then(data => {
                    console.log("Search results:", data); // Log the response data

                    const resultContainer = document.getElementById("search-results");
                    resultContainer.innerHTML = "";

                    if (data.length > 0) {
                        resultContainer.style.display = "block";
                        data.forEach(product => {
                            const item = document.createElement("li");
                            item.innerHTML = `<a href="${product.url}">${product.nome}</a>`;
                            resultContainer.appendChild(item);
                        });
                    } else {
                        resultContainer.innerHTML = "<li>No results found.</li>";
                        resultContainer.style.display = "block";
                    }
                })

                .catch(error => {
                    console.error("Error fetching products:", error);
                    const resultContainer = document.getElementById("search-results");
                    resultContainer.innerHTML = "<li>Unable to fetch results. Please try again later.</li>";
                    resultContainer.style.display = "block";
                });
        }, 300);
    }
</script>

</html>
<?php $this->endPage();
