<!DOCTYPE html>
<html lang="en">
<!-- Basic -->
<body>
    <!-- Start Cart  -->
    <div class="cart-box-main">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="table-main table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Images</th>
                                    <th>Product Name</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th>Remove</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($userCart->linhacarrinhoprodutos as $linhacarrinho): ?>
                                    <?php
                                    $produto = $linhacarrinho->produto;
                                    $productImages = $produto->imagems;
                                    if (!empty($productImages)):
                                        $firstImage = $productImages[0];
                                    endif;
                                    ?>
                                    <tr>
                                        <td class="thumbnail-img">
                                            <a href="<?= yii\helpers\Url::to(['produto/product-details', 'id' => $produto->id]) ?>">
                                                <img class="img-fluid" src="<?= yii\helpers\Url::to('../../backend/web/uploads/' . $firstImage->filename) ?>" alt="" />
                                            </a>
                                        </td>
                                        <td class="name-pr">
                                            <a href="<?= yii\helpers\Url::to(['produto/product-details', 'id' => $produto->id]) ?>">
                                                <?= $produto->nome ?>
                                            </a>
                                        </td>
                                        <td class="price-pr">
                                            <?= $produto->preco ?>€
                                        </td>
                                        <td class="quantity-box">
                                            <form method="POST" action="<?= yii\helpers\Url::to(['user/update-quantity']) ?>">
                                                <input type="hidden" name="<?= Yii::$app->request->csrfParam ?>" value="<?= Yii::$app->request->csrfToken ?>" />
                                                <input type="hidden" name="itemId" value="<?= $linhacarrinho->id ?>" />
                                                <input type="number" name="quantity" value="<?= $linhacarrinho->quantidade ?>" min="1" step="1" class="c-input-text qty text">
                                                <button type="submit" style="display:none;">Update</button>
                                            </form>

                                        </td>
                                        <td class="total-pr">
                                            <p><?= $produto->preco * $linhacarrinho->quantidade ?>€</p>
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

            <div class="row my-5">
                <div class="col-lg-8 col-sm-12"></div>
                <div class="col-lg-4 col-sm-12">
                    <div class="order-box">
                        <h3>Order summary</h3>
                        <div class="d-flex">
                            <h4>Sub Total</h4>
                            <div class="ml-auto font-weight-bold"><?= $userCart->total ?>€</div>
                        </div>
                        <hr class="my-1">
                        <div class="d-flex">
                            <h4>Shipping Cost</h4>
                            <div class="ml-auto font-weight-bold"><?=$shippingCost = 0?>€</div>
                        </div>
                        <hr>
                        <div class="d-flex gr-total">
                            <h5>Grand Total</h5>
                            <div class="ml-auto h5"><?=$userCart->total + $shippingCost?>€</div>
                        </div>
                        <hr>
                    </div>
                </div>
                <div class="col-12 d-flex shopping-box"><a href="<?= yii\helpers\Url::to(['user/checkout']) ?>" class="ml-auto btn hvr-hover">Checkout</a> </div>
            </div>

        </div>
    </div>
    <!-- End Cart -->
</body>

</html>