<!DOCTYPE html>
<html lang="en">
<!-- Basic -->

<body>
    <!-- Start Cart  -->
    <div class="cart-box-main">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <?php if (empty($userCart->linhacarrinhoprodutos)): ?>
                        <div class="alert alert-info text-center mt-5 py-4" role="alert" style="border-radius: 15px;">
                            <h4 class="alert-heading mb-3" style="font-weight: 600;">
                                <i class="fas fa-shopping-cart text-primary"></i> Your Cart is Empty!
                            </h4>
                            <p style="font-size: 16px;">It looks like your cart is empty. Discover our products and start shopping now!</p>
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
                                        if (!$produto) {
                                            continue;
                                        }
                                        $productImages = $produto->imagems ?? [];
                                        $firstImage = $productImages[0] ?? null;
                                        $imageUrl = $firstImage ? yii\helpers\Url::to('../../backend/web/uploads/' . $firstImage->filename) : yii\helpers\Url::to('/path/to/placeholder.jpg');
                                        ?>
                                        <tr>
                                            <td class="thumbnail-img">
                                                <a href="<?= yii\helpers\Url::to(['produto/product-details', 'id' => $produto->id]) ?>">
                                                    <img class="img-fluid" src="<?= $imageUrl ?>" alt="" />
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
                                            <?php if (Yii::$app->user->can('updateQuantity')): ?>
                                                <td class="quantity-box">
                                                    <form method="POST" action="<?= yii\helpers\Url::to(['carrinhoproduto/update-quantity']) ?>">
                                                        <input type="hidden" name="<?= Yii::$app->request->csrfParam ?>" value="<?= Yii::$app->request->csrfToken ?>" />
                                                        <input type="hidden" name="itemId" value="<?= $linhacarrinho->id ?>" />
                                                        <input type="number" name="quantity" value="<?= $linhacarrinho->quantidade ?>" min="1" step="1" class="c-input-text qty text form-control form-control-sm" style="max-width: 80px;">
                                                        <button type="submit" style="display:none;">Update</button>
                                                    </form>
                                                </td>
                                            <?php endif; ?>
                                            <td class="total-pr">
                                                <p><?= $produto->preco * $linhacarrinho->quantidade ?>€</p>
                                            </td>
                                            <?php if (Yii::$app->user->can('removeFromCart')): ?>
                                                <td class="remove-pr">
                                                    <a href="<?= yii\helpers\Url::to(['carrinhoproduto/delete', 'cartItemId' => $linhacarrinho->id]) ?>">
                                                        <i class="fas fa-times"></i>
                                                    </a>
                                                </td>
                                            <?php endif; ?>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php if (!empty($userCart->linhacarrinhoprodutos)): ?>
                <div class="row my-5">
                    <div class="col-lg-4 offset-lg-8 col-sm-12">
                        <div class="card shadow-sm border-2 rounded">
                            <div class="card-body">
                                <h4 class="card-title text-center"><b>Order Summary</b></h4>
                                <hr style="border: 1px solid #000;">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h4 class="mb-0">Total</h4>
                                    <span class="font-weight-bold h5"><strong><?= $userCart->total ?>€</strong></span>
                                </div>
                                <?php if (Yii::$app->user->can('cartCheckout')): ?>
                                    <a href="<?= yii\helpers\Url::to(['fatura/index']) ?>" class="btn btn-success btn-block mt-3">
                                        <i class="fas fa-credit-card"></i> Checkout
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <!-- End Cart -->
</body>

</html>