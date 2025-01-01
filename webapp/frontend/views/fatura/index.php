<!DOCTYPE html>
<html lang="en">

<body>
    <div class="cart-box-main">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-lg-6 mb-3">
                    <div class="checkout-address">
                        <div class="title-left">
                            <h3>Billing Address</h3>
                        </div>
                        <form action="<?= yii\helpers\Url::to(['fatura/confirm-checkout']) ?>" method="post">
                            <input type="hidden" name="<?= Yii::$app->request->csrfParam ?>" value="<?= Yii::$app->request->csrfToken ?>">
                            <div class="mb-3">
                                <label for="fullName">Full Name *</label>
                                <input type="text" class="form-control" id="fullName" name="fullName" value="<?= isset($userProfile->nome) ? $userProfile->nome : null ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="address">Address *</label>
                                <input type="text" class="form-control" id="address" name="address" value="<?= isset($userProfile->morada) ? $userProfile->morada : null ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="phone">Phone Number *</label>
                                <input type="tel" class="form-control" id="phone" name="phone" value="<?= isset($userProfile->telefone) ? $userProfile->telefone : null ?>" pattern="^\d{9}$" title="Phone number must be exactly 9 digits">
                            </div>
                            <div class="mb-3">
                                <label for="nif">NIF *</label>
                                <input type="text" class="form-control" id="nif" name="nif" value="<?= isset($userProfile->nif) ? $userProfile->nif : null ?>" pattern="^\d{9}$" title="NIF number must be exactly 9 digits">
                            </div>
                            <div class="title-left">
                                <h3>Payment Methods</h3>
                            </div>
                            <div class="d-block my-3">
                                <?php foreach ($paymentMethods as $paymentMethod): ?>
                                    <div class="custom-control custom-radio">
                                        <input id="paymentMethod<?= $paymentMethod->id ?>" name="paymentMethod" class="custom-control-input" type="radio" value="<?= $paymentMethod->id ?>" required>
                                        <label class="custom-control-label" for="paymentMethod<?= $paymentMethod->id ?>"><?= $paymentMethod->descricao ?></label>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <div class="title-left">
                                <h3>Shipping Methods</h3>
                            </div>
                            <div class="d-block my-3">
                                <?php foreach ($shippingMethods as $shippingMethod): ?>
                                    <div class="custom-control custom-radio">
                                        <input id="shippingMethod<?= $shippingMethod->id ?>" name="shippingMethod" class="custom-control-input" type="radio" value="<?= $shippingMethod->id ?>" required>
                                        <label class="custom-control-label" for="shippingMethod<?= $shippingMethod->id ?>"><?= $shippingMethod->descricao ?></label>
                                        <span class="float-right font-weight-bold"><?= $shippingMethod->preco == 0 ? 'Free' : $shippingMethod->preco . '€' ?></span>
                                    </div>
                                    <div class="ml-4 mb-2 small">(<?= $shippingMethod->duracao ?>)</div>
                                <?php endforeach; ?>
                            </div>
                            <div class="text-end">
                                <?php if (Yii::$app->user->can('confirmCheckout')): ?>
                                    <button type="submit" class="btn btn-success btn-lg">
                                        <i class="fas fa-credit-card"></i> Proceed to Confirm Order
                                    </button>
                                <?php endif; ?>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-6 mb-3">
                    <div class="row">
                        <div class="col-md-12 col-lg-12">
                            <div class="odr-box">
                                <div class="title-left">
                                    <h3>Shopping Cart</h3>
                                </div>
                                <div class="rounded p-2 bg-light">
                                    <?php foreach ($userCart->linhacarrinhoprodutos as $linhacarrinho): ?>
                                        <div class="media mb-2 border-bottom">
                                            <div class="media-body">
                                                <a href="detail.html"><?= $linhacarrinho->produto->nome ?></a>
                                                <div class="small text-muted">
                                                    Price: <?= $linhacarrinho->precounitario ?>€
                                                    <span class="mx-2">|</span> Qty: <?= $linhacarrinho->quantidade ?>
                                                    <span class="mx-2">|</span> Subtotal: <?= $linhacarrinho->precounitario * $linhacarrinho->quantidade ?>€
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                <div class="d-flex gr-total">
                                    <h5>Cart Total</h5>
                                    <div class="ml-auto h5"><?= $userCart->total ?>€</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>