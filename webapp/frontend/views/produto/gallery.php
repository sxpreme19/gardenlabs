<!DOCTYPE html>
<html lang="en">
<!-- Basic -->

<body>
    <!-- Start Gallery  -->
    <div class="products-box">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="title-all text-center">
                        <h1>Our Gallery</h1>
                        <h3>Feel free to explore our <b><?= $productTotalCount ?></b> products!</h3>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="special-menu text-center">
                        <div class="button-group filter-button-group">
                            <button class="active" data-filter="*">All</button>
                            <?php foreach ($categories as $category): ?>
                                <button data-filter=".<?= $category->id ?>"><?= $category->nome ?></button>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row special-list">
                <?php foreach ($products as $product): ?>
                    <div class="col-lg-3 col-md-6 special-grid <?= $product->categoria_id ?>">
                        <div class="products-single fix">
                            <div class="box-img-hover">
                                <div class="type-lb">
                                    <p class="sale">Sale</p>
                                </div>
                                <?php
                                $productImages = $product->imagems;
                                if (!empty($productImages)):
                                    $firstImage = $productImages[0];
                                ?>
                                    <img src="<?= yii\helpers\Url::to('../../backend/web/uploads/' . $firstImage->filename) ?>" class="img-fluid" alt="Image">
                                <?php endif; ?>
                                <div class="mask-icon">
                                    <ul>
                                        <li><a href=<?= yii\helpers\Url::to(['produto/product-details', 'id' => $product->id]) ?> data-toggle="tooltip" data-placement="right" title="View"><i class="fas fa-eye"></i></a></li>
                                        <?php if ($userWishlistIds != null && in_array($product->id, $userWishlistIds)): ?>
                                            <li><a href="<?= yii\helpers\Url::to(['favorito/delete', 'productId' => $product->id]) ?>" data-toggle="tooltip" data-placement="right" title="Remove from Wishlist"><i class="fas fa-heart"></i></a></li>
                                        <?php else: ?>
                                            <li><a href="<?= yii\helpers\Url::to(['favorito/add-to-wishlist', 'productId' => $product->id]) ?>" data-toggle="tooltip" data-placement="right" title="Add to Wishlist"><i class="far fa-heart"></i></a></li>
                                        <?php endif; ?>
                                    </ul>
                                    <a class="cart" href="<?= yii\helpers\Url::to(['carrinhoproduto/add-to-cart', 'productId' => $product->id, 'productQuantity' => 1]) ?>">Add to Cart</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <!-- End Gallery  -->
</body>

</html>