<!DOCTYPE html>
<html lang="en">
<!-- Basic -->

<body>
    <!-- Start Wishlist  -->
    <div class="wishlist-box-main">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <?php if (empty($userWishlist)): ?>
                        <div class="alert alert-info text-center mt-5 py-4" role="alert" style="border-radius: 15px;">
                            <h4 class="alert-heading mb-3" style="font-weight: 600;">
                                <i class="fas fa-heart text-danger"></i> Your Wishlist is Empty!
                            </h4>
                            <p style="font-size: 16px;">It looks like you haven’t added any items to your wishlist yet. Discover our products and save your favorites!</p>
                            <a href="<?= yii\helpers\Url::to(['produto/index']) ?>" class="btn btn-primary mt-3" style="padding: 10px 20px; font-size: 16px;">
                                <i class="fas fa-store"></i> Browse Products
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="table-main table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Images</th>
                                        <th>Product Name</th>
                                        <th>Unit Price </th>
                                        <th>Stock</th>
                                        <th>Add Item</th>
                                        <th>Remove</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($userWishlist as $wishlistItem): ?>
                                        <tr>
                                            <td class="thumbnail-img">
                                                <a href=<?= yii\helpers\Url::to(['produto/product-details', 'id' => $wishlistItem->produto->id]) ?>>
                                                    <?php
                                                    $productImages = $wishlistItem->produto->imagems;
                                                    if (!empty($productImages)):
                                                        $firstImage = $productImages[0];
                                                    ?>
                                                        <img src="<?= yii\helpers\Url::to('../../backend/web/uploads/' . $firstImage->filename) ?>" class="img-fluid" alt=<?= $wishlistItem->produto->nome ?>>
                                                    <?php endif; ?>
                                                </a>
                                            </td>
                                            <td class="name-pr">
                                                <a href=<?= yii\helpers\Url::to(['produto/product-details', 'id' => $wishlistItem->produto->id]) ?>>
                                                    <?= $wishlistItem->produto->nome ?>
                                                </a>
                                            </td>
                                            <td class="price-pr">
                                                <p><?= $wishlistItem->produto->preco ?>€</p>
                                            </td>
                                            <td class="quantity-box"><?= $wishlistItem->produto->quantidade ?> available</td>
                                            <td class="add-pr">
                                                <a class="btn hvr-hover" style="color:white" href="<?= yii\helpers\Url::to(['carrinhoproduto/add-to-cart', 'productId' => $wishlistItem->produto->id, 'productQuantity' => 1]) ?>">Add to Cart</a>
                                            </td>
                                            <td class="remove-pr">
                                                <?php if (Yii::$app->user->can('removeFromWishlist')): ?>
                                                <a href="<?= yii\helpers\Url::to(['favorito/delete', 'productId' => $wishlistItem->produto->id]) ?>">
                                                    <i class="fas fa-times"></i>
                                                </a>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <!-- End Wishlist -->
</body>

</html>