<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<!DOCTYPE html>
<html lang="en">
<!-- Basic -->

<head>
    <style type="text/css">
        #review-form:target {
            display: block !important;
        }
    </style>
</head>

<body>
    <!-- Start Shop Detail  -->
    <div class="shop-detail-box-main">
        <div class="container">
            <div class="row">
                <div class="col-xl-5 col-lg-5 col-md-6">
                    <div id="carousel-example-1" class="single-product-slider carousel slide" data-ride="carousel">
                        <div class="carousel-inner" role="listbox">
                            <?php
                            if (!empty($productImages)):
                                foreach ($productImages as $index => $image):
                                    $activeClass = $index == 0 ? 'active' : '';
                            ?>
                                    <div class="carousel-item <?= $activeClass ?>">
                                        <img class="d-block w-100" src="<?= yii\helpers\Url::to('../../backend/web/uploads/' . $image->filename) ?>" alt="Product Image <?= $index + 1 ?>">
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>

                        <!-- Previous and Next controls -->
                        <a class="carousel-control-prev" href="#carousel-example-1" role="button" data-slide="prev">
                            <i class="fa fa-angle-left" aria-hidden="true"></i>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carousel-example-1" role="button" data-slide="next">
                            <i class="fa fa-angle-right" aria-hidden="true"></i>
                            <span class="sr-only">Next</span>
                        </a>

                        <!-- Carousel indicators -->
                        <ol class="carousel-indicators">
                            <?php
                            $inc = 0;
                            if (!empty($productImages)):
                                foreach ($productImages as $index => $image):
                            ?>
                                    <li data-target="#carousel-example-1" data-slide-to="<?= $inc ?>" class="<?= $index == 0 ? 'active' : '' ?>">
                                        <img class="d-block w-100 img-fluid" src="<?= yii\helpers\Url::to('../../backend/web/uploads/' . $image->filename) ?>" alt="Product Image <?= $index + 1 ?>">
                                    </li>
                            <?php
                                    $inc++;
                                endforeach;
                            endif;
                            ?>
                        </ol>
                    </div>
                </div>
                <div class="col-xl-7 col-lg-7 col-md-6">
                    <div class="single-product-details">
                        <h2><?= $product->nome ?></h2>
                        <h5> <del></del><?= $product->preco ?>€</h5>
                        <p class="available-stock"><span><?= $product->quantidade ?> available<a href="#"></a></span>
                        <h5>Short Description</h5>
                        <div class="border p-4 rounded bg-light">
                            <p class="text-dark"><?= $product->descricao ?></p>
                        </div>
                        <?php if (!empty($reviews)): ?>
                            <div class="rating" style="font-family: Arial, sans-serif; font-size: 1.5rem; color: #ffc107; display: flex; align-items: center;">
                                <div class="stars" style="display: flex;">
                                    <?php
                                    for ($i = 1; $i <= 5; $i++):
                                    ?>
                                        <span style="margin-right: 0.2rem;">
                                            <?= $i <= floor($rating) ? '★' : ($i - $rating < 1 && $i > $rating ? '☆' : '☆') ?>
                                        </span>
                                    <?php endfor; ?>
                                </div>
                                <div class="rating-value" style="margin-left: 0.5rem; font-size: 1.2rem; color: #555;">
                                    (<?= number_format($rating, 1) ?>)
                                </div>
                            </div>
                        <?php endif; ?>

                        <br>
                        <div class="price-box-bar">
                            <div class="cart-and-bay-btn">
                                <?php if (Yii::$app->user->can('addToCart')) : ?>
                                    <a href=<?= yii\helpers\Url::to(['carrinhoproduto/add-to-cart', 'productId' => $product->id, 'productQuantity' => 1]) ?> class="btn hvr-hover" data-fancybox-close="">Add to cart</a>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="add-to-btn">
                            <div class="add-comp">
                                <?php if (Yii::$app->user->can('addToWishlist')) : ?>
                                    <a class="btn hvr-hover" href=<?= yii\helpers\Url::to(['favorito/add-to-wishlist', 'productId' => $product->id]) ?>><i class="fas fa-heart"></i> Add to wishlist</a>
                                <?php endif; ?>

                            </div>
                            <div class="category-container d-flex justify-content-end align-items-center">
                                <span class="badge bg-primary text-light px-4 py-2">
                                    <strong><?= $product->categoria->nome ?></strong>
                                </span>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="row my-5">
                <div class="card card-outline-secondary my-4">
                    <div class="card-header">
                        <h2>Product Reviews</h2>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($reviews)): ?>
                            <div class="reviews-scrollable overflow-auto" style="max-height: 200px;">
                                <?php foreach ($reviews as $review): ?>
                                    <div class="media mb-3">
                                        <div class="mr-2">
                                            <i class="fas fa-user-circle" style="font-size: 64px; color: #007bff;"></i>
                                        </div>
                                        <div class="media-body">
                                            <p><?= $review->conteudo ?></p>
                                            <div class="rating">
                                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                                    <i class="fas fa-star" style="color: <?= ($i <= $review->avaliacao) ? 'gold' : '#ddd' ?>;"></i>
                                                <?php endfor; ?>
                                            </div>
                                            <small class="text-muted">Posted by <?= $review->userprofile->nome ?> on <?= $review->datahora ?></small>
                                            <?php if (Yii::$app->user->can('deleteOwnReview')): ?>
                                                <?php if ($review->userprofile_id == Yii::$app->user->identity->userProfile->id): ?>
                                                    <a href="<?= yii\helpers\Url::to(['produto/delete-review', 'id' => $review->id]) ?>"
                                                        class="text-danger ml-3"
                                                        onclick="return confirm('Are you sure you want to delete this review?');">
                                                        <i class="fas fa-trash-alt" style="font-size: 20px;"></i>
                                                    </a>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <hr>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <div class="media mb-3">
                                <div class="media-body">
                                    <p>No reviews found!</p>
                                </div>
                            </div>
                            <hr>
                        <?php endif; ?>
                        <?php if (Yii::$app->user->can('leaveReview')): ?>
                            <a href="#review-form" class="btn hvr-hover" id="leave-review-btn">Leave a Review</a>
                            <div id="review-form" style="display: none; margin-top: 20px;">
                                <?php $form = ActiveForm::begin(); ?>

                                <?= $form->field($model, 'conteudo')->textarea(['rows' => 4])->label('Your Review') ?>
                                <?= $form->field($model, 'avaliacao')->dropDownList([
                                    1 => '1 - Poor',
                                    2 => '2 - Fair',
                                    3 => '3 - Good',
                                    4 => '4 - Very Good',
                                    5 => '5 - Excellent',
                                ])->label('Your Rating') ?>
                                <div class="form-group">
                                    <?= Html::submitButton('Submit Review', ['class' => 'btn hvr-hover']) ?>
                                </div>

                                <?php ActiveForm::end(); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Cart -->
</body>

</html>