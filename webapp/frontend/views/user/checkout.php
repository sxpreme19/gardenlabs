<!DOCTYPE html>
<html lang="en">
<!-- Basic -->

<body>
    <!-- Start Cart  -->
    <div class="cart-box-main">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-lg-6 mb-3">
                    <div class="checkout-address">
                        <div class="title-left">
                            <h3>Billing address</h3>
                        </div>
                        <form class="needs-validation" action="confirm-checkout.php" method="get" novalidate>
                            <div class="row">
                                <div class="mb-3">
                                    <label for="firstName">Full name *</label>
                                    <input type="text" class="form-control" id="firstName" placeholder="Enter your full name" value="<?= isset($userProfile->nome) ? $userProfile->nome : null ?>" required>
                                    <div class="invalid-feedback"> Valid first name is required. </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="username">Username *</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="username" placeholder="Enter your username" value="<?= isset(Yii::$app->user->identity->username) ? Yii::$app->user->identity->username : null ?>" required>
                                    <div class="invalid-feedback" style="width: 100%;"> Your username is required. </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="email">Email Address *</label>
                                <input type="email" class="form-control" id="email" placeholder="Enter your email" value="<?= isset(Yii::$app->user->identity->email) ? Yii::$app->user->identity->email : null ?>" required>
                                <div class="invalid-feedback"> Please enter a valid email address for shipping updates. </div>
                            </div>
                            <div class="mb-3">
                                <label for="address">Address *</label>
                                <input type="text" class="form-control" id="address" placeholder="Enter your address" value="<?= isset($userProfile->morada) ? $userProfile->morada : null ?>" required>
                                <div class="invalid-feedback"> Please enter your shipping address. </div>
                            </div>
                            <div class="mb-3">
                                <label for="phone">Phone number *</label>
                                <input type="tel" class="form-control" id="phone" placeholder="Enter your phone number" value="<?= isset($userProfile->telefone) ? $userProfile->telefone : null ?>" required>
                                <div class="invalid-feedback"> Please enter your shipping address. </div>
                            </div>
                            <div class="mb-3">
                                <label for="nif">NIF *</label>
                                <input type="text" class="form-control" id="nif" placeholder="Enter your nif" value="<?= isset($userProfile->nif) ? $userProfile->nif : null ?>" required>
                                <div class="invalid-feedback"> Please enter your shipping address. </div>
                            </div>
                            <div class="title-left">
                                <h3>Payment Methods</h3>
                            </div>
                            <div class="d-block my-3">
                                <?php foreach ($paymentMethods as $paymentMethod): ?>
                                    <div class="custom-control custom-radio">
                                        <input
                                            id="paymentMethod<?= $paymentMethod->id ?>"
                                            name="checkoutSelectedPaymentMethod"
                                            type="radio"
                                            class="custom-control-input"
                                            value="<?= $paymentMethod->id ?>"
                                            required>
                                        <label class="custom-control-label" for="paymentMethod<?= $paymentMethod->id ?>"><?= $paymentMethod->descricao ?></label>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-6 mb-3">
                    <div class="row">
                        <div class="col-md-12 col-lg-12">
                            <div class="shipping-method-box">
                                <div class="title-left">
                                    <h3>Shipping Method</h3>
                                </div>
                                <div class="mb-4">
                                    <?php foreach ($shippingMethods as $shippingMethod): ?>
                                        <div class="custom-control custom-radio">
                                            <input
                                                id="shippingMethod<?= $shippingMethod->id ?>"
                                                name="checkoutSelectedShippingMethod"
                                                type="radio"
                                                class="custom-control-input"
                                                value="<?= $shippingMethod->id ?>"
                                                required>
                                            <label class="custom-control-label" for="shippingMethod<?= $shippingMethod->id ?>"><?= $shippingMethod->descricao ?></label>
                                            <span class="float-right font-weight-bold"><?= $shippingMethod->preco == 0 ? 'Free' : $shippingMethod->preco . '€' ?></span>
                                        </div>
                                        <div class="ml-4 mb-2 small">(<?= $shippingMethod->duracao ?>)</div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-12">
                            <div class="odr-box">
                                <div class="title-left">
                                    <h3>Shopping cart</h3>
                                </div>
                                <div class="rounded p-2 bg-light">
                                    <?php foreach ($userCart->linhacarrinhoprodutos as $linhacarrinho): ?>
                                        <div class="media mb-2 border-bottom">
                                            <div class="media-body"> <a href="detail.html"><?= $linhacarrinho->produto->nome ?></a>
                                                <div class="small text-muted">Price: <?= $linhacarrinho->precounitario ?>€ <span class="mx-2">|</span> Qty: <?= $linhacarrinho->quantidade ?> <span class="mx-2">|</span> Subtotal: <?= $linhacarrinho->precounitario * $linhacarrinho->quantidade ?>€</div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-12">
                            <div class="odr-box">
                                <div class="title-left">
                                    <h3>Your order</h3>
                                </div>
                                <div class="d-flex">
                                    <div class="font-weight-bold">Product</div>
                                    <div class="ml-auto font-weight-bold">Total</div>
                                </div>
                                <hr class="my-1">
                                <div class="d-flex">
                                    <h4>Sub Total</h4>
                                    <div class="ml-auto font-weight-bold"><?= $userCart->total ?>€</div>
                                </div>
                                <div class="d-flex">
                                    <h4>Shipping Cost</h4>
                                    <div class="ml-auto font-weight-bold"><?= $shippingMethod->preco ?>€</div>
                                </div>
                                <hr>
                                <div class="d-flex gr-total">
                                    <h5>Grand Total</h5>
                                    <div class="ml-auto h5"><?= $userCart->total + $shippingMethod->preco ?>€</div>
                                </div>
                                <hr>
                            </div>
                        </div>
                        <div class="col-12 d-flex justify-content-end">
                            <a href="<?= yii\helpers\Url::to(['user/confirm-checkout']) ?>" class="btn btn-success btn-block mt-3" style="max-width: 200px;" data-base-url="<?= yii\helpers\Url::to(['user/confirm-checkout']) ?>">
                                <i class="fas fa-credit-card"></i> Place Order
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- End Cart -->
</body>

</html>