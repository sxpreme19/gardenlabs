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
                        <div class="empty-wishlist">
                            <h3>You have no favorite items in your wishlist.</h3>
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
                                                <a class="btn hvr-hover" href="<?= yii\helpers\Url::to(['user/add-to-cart', 'productId' => $wishlistItem->produto->id, 'productQuantity' => 1]) ?>">Add to Cart</a>
                                            </td>
                                            <td class="remove-pr">
                                                <a href="<?= yii\helpers\Url::to(['user/remove-wishlist-item', 'productId' => $wishlistItem->produto->id]) ?>">
                                                    <i class="fas fa-times"></i>
                                                </a>
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