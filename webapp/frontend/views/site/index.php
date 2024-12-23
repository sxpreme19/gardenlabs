<!DOCTYPE html>
<html lang="en">
<!-- Basic -->

<body>
    <!-- Start Slider -->
    <div id="slides-shop" class="cover-slides">
        <ul class="slides-container">
            <li class="text-center">
                <img src="images/banner-01.jpg" alt="">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <h1 class="m-b-20"><strong>Welcome To <br> GardenLabs</strong></h1>
                            <p class="m-b-40">Explore our wide variety of premium plants and gardening tools. <br> Enhance your garden with quality products today.</p>
                            <p><a class="btn hvr-hover" href="<?= \yii\helpers\Url::to(['produto/index']) ?>">Shop New</a></p>
                        </div>
                    </div>
                </div>
            </li>
            <li class="text-center">
                <img src="images/banner-02.jpg" alt="">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <h1 class="m-b-20"><strong>Welcome To <br> GardenLabs</strong></h1>
                            <p class="m-b-40">Discover a variety of plants, tools, and accessories <br> that will help your garden thrive in every season.</p>
                            <p><a class="btn hvr-hover" href="<?= \yii\helpers\Url::to(['produto/index']) ?>">Shop New</a></p>
                        </div>
                    </div>
                </div>
            </li>
            <li class="text-center">
                <img src="images/banner-03.jpg" alt="">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <h1 class="m-b-20"><strong>Welcome To <br> GardenLabs</strong></h1>
                            <p class="m-b-40">Transform your garden with our hand-picked selection of plants and accessories. <br> Start your gardening journey today with GardenLabs.</p>
                            <p><a class="btn hvr-hover" href="<?= \yii\helpers\Url::to(['produto/index']) ?>">Shop New</a></p>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
        <div class="slides-navigation">
            <a href="#" class="next"><i class="fa fa-angle-right" aria-hidden="true"></i></a>
            <a href="#" class="prev"><i class="fa fa-angle-left" aria-hidden="true"></i></a>
        </div>
    </div>
    <!-- End Slider -->

    <!-- Start Categories -->
    <div class="categories-shop">
        <div class="container">
            <div class="row justify-content-center">
                <?php foreach ($categories as $index => $category): ?>
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 d-flex justify-content-center mb-4">
                        <div class="shop-cat-box text-center">
                            <img class="img-fluid" src="<?= $categoryImages[$index] ?>" alt="Category Image" />
                            <a class="btn hvr-hover" href="<?= \yii\helpers\Url::to(['produto/index', 'categoria_id' => $category->id]) ?>"><?= $category->nome ?></a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <!-- End Categories -->

    <div class="box-add-products">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="offer-box-products">
                        <img class="img-fluid" src="images/add-img-03.jpg" alt="" />
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="offer-box-products">
                        <img class="img-fluid" src="images/add-img-04.jpg" alt="" />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Start Products  -->
    <div class="products-box">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="title-all text-center">
                        <h1>Best Sellers</h1>
                        <p>Check out our best selling products!</p>
                    </div>
                </div>
            </div>
            <div class="row special-list">
                <?php foreach ($bestSellers as $bestseller): ?>
                    <div class="col-lg-3 col-md-6 special-grid best-seller">
                        <div class="products-single fix">
                            <div class="box-img-hover">
                                <?php
                                $productImages = $bestseller->imagems;
                                if (!empty($productImages)):
                                    $firstImage = $productImages[0];
                                ?>
                                    <img src="<?= yii\helpers\Url::to('../../backend/web/uploads/' . $firstImage->filename) ?>" class="img-fluid" alt=<?= $bestseller->nome ?>>
                                <?php endif; ?>
                                <div class="mask-icon">
                                    <ul>
                                        <li><a href=<?= yii\helpers\Url::to(['produto/product-details', 'id' => $bestseller->id]) ?> data-toggle="tooltip" data-placement="right" title="View"><i class="fas fa-eye"></i></a></li>
                                        <?php if ($userWishlistIds != null): ?>
                                            <?php if (in_array($bestseller->id, $userWishlistIds)): ?>
                                                <li><a href="<?= yii\helpers\Url::to(['favorito/delete', 'productId' => $bestseller->id]) ?>" data-toggle="tooltip" data-placement="right" title="Remove from Wishlist"><i class="fas fa-heart"></i></a></li>
                                            <?php else: ?>
                                                <li><a href="<?= yii\helpers\Url::to(['favorito/add-to-wishlist', 'productId' => $bestseller->id]) ?>" data-toggle="tooltip" data-placement="right" title="Add to Wishlist"><i class="far fa-heart"></i></a></li>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </ul>
                                    <a class="cart" href="<?= yii\helpers\Url::to(['carrinhoproduto/add-to-cart', 'productId' => $bestseller->id, 'productQuantity' => 1]) ?>">Add to Cart</a>
                                </div>
                            </div>
                            <div class="why-text">
                                <h4><?= $bestseller->nome ?></h4>
                                <h5><?= $bestseller->preco ?>€</h5>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <!-- End Products  -->

    <!-- Start Blog -->
    <div class="latest-blog">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="title-all text-center">
                        <h1>3 Common Gardening Myths You Should Stop Believing</h1>
                        <p>There are many gardening myths out there. Let's debunk some of the most common ones!</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-lg-4 col-xl-4">
                    <div class="blog-box">
                        <div class="blog-img">
                            <img class="img-fluid" src="images/blog-img.jpg" alt="Watering Plants at Night">
                        </div>
                        <div class="blog-content">
                            <div class="title-blog">
                                <h3>Myth #1: Watering Plants at Night Causes Root Rot</h3>
                                <p>Many gardeners believe that watering at night leads to root rot because water doesn't evaporate quickly. It's fine as long as you avoid over-watering and ensure proper drainage.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 col-xl-4">
                    <div class="blog-box">
                        <div class="blog-img">
                            <img class="img-fluid" src="images/blog-img-01.jpg" alt="Fertilizing Every Week">
                        </div>
                        <div class="blog-content">
                            <div class="title-blog">
                                <h3>Myth #2: You Need to Fertilize Every Week</h3>
                                <p>Over-fertilizing can harm your plants! It's best to fertilize based on plant needs, usually once a month during the growing season. Avoid weekly feedings to protect your plants from root damage.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 col-xl-4">
                    <div class="blog-box">
                        <div class="blog-img">
                            <img class="img-fluid" src="images/blog-img-02.jpg" alt="Soil Myth">
                        </div>
                        <div class="blog-content">
                            <div class="title-blog">
                                <h3>Myth #3: You Can Grow Anything in Any Soil</h3>
                                <p>Soil quality matters! Plants thrive in specific soil types. Amending your soil with organic matter will improve its fertility and structure, ensuring a healthier garden.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Blog -->

</body>

</html>