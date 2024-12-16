<!DOCTYPE html>
<html lang="en">
<!-- Basic -->

<body>
    <!-- Start Wishlist  -->
    <div class="wishlist-box-main">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
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
                                                    <img src="<?= yii\helpers\Url::to('../../backend/web/uploads/' . $firstImage->filename) ?>" class="img-fluid" alt=<?=$wishlistItem->produto->nome?>>
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
                                            <a class="btn hvr-hover" href="#">Add to Cart</a>
                                        </td>
                                        <td class="remove-pr">
                                            <a href="#">
                                                <i class="fas fa-times"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Wishlist -->

    <!-- ALL JS FILES -->
    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <!-- ALL PLUGINS -->
    <script src="js/jquery.superslides.min.js"></script>
    <script src="js/bootstrap-select.js"></script>
    <script src="js/inewsticker.js"></script>
    <script src="js/bootsnav.js."></script>
    <script src="js/images-loded.min.js"></script>
    <script src="js/isotope.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/baguetteBox.min.js"></script>
    <script src="js/form-validator.min.js"></script>
    <script src="js/contact-form-script.js"></script>
    <script src="js/custom.js"></script>
</body>

</html>