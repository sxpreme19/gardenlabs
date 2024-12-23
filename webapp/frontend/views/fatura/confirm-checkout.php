<!DOCTYPE html>
<html lang="en">

<body>
    <div class="container py-5">
        <div class="text-center mb-4">
            <h1 class="display-5">Confirm Your Order</h1>
            <p class="text-muted">Review your details before proceeding to payment</p>
        </div>
        <div class="row g-5">
            <div class="col-lg-8">
                <div class="card mb-4 shadow-sm">
                    <div class="card-header bg-dark text-white">Order Summary</div>
                    <div class="card-body">
                        <table class="table align-middle">
                            <thead class="table-light">
                                <tr class="text-muted">
                                    <th>Product</th>
                                    <th>Quantity</th>
                                    <th>Unit Price</th>
                                    <th class="text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($userCart->linhacarrinhoprodutos as $cartItem): ?>
                                    <tr>
                                        <td><?= $cartItem->produto->nome ?></td>
                                        <td><?= $cartItem->quantidade ?></td>
                                        <td><?= $cartItem->precounitario ?>€</td>
                                        <td class="text-end"><?= $cartItem->precounitario * $cartItem->quantidade ?>€</td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <strong>Subtotal</strong>
                            <p><?= $userCart->total ?>€</p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <strong>Shipping Cost</strong>
                            <p><?= $shippingMethod->preco == 0 ? 'Free' : $shippingMethod->preco . '€' ?></p>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <strong class="grand-total">Grand Total</strong>
                            <strong class="grand-total"><?= $userCart->total + $shippingMethod->preco ?>€</strong>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <?php if (
                    $nome == $userProfile->nome &&
                    $morada == $userProfile->morada &&
                    $phone == $userProfile->telefone &&
                    $nif == $userProfile->nif
                ): ?>
                    <div class="card mb-4 shadow-sm">
                        <div class="card-header bg-success text-white">Payment & Shipping</div>
                        <div class="card-body">
                            <p><strong>Name:</strong> <?= $nome ?></p>
                            <p><strong>Email:</strong> <?= Yii::$app->user->identity->email ?></p>
                            <p><strong>Address:</strong> <?= $morada ?></p>
                            <?php if ($phone != null): ?>
                            <p><strong>Phone:</strong> <?= $phone ?></p>
                            <?php endif; ?>
                            <?php if ($nif != null): ?>
                            <p><strong>NIF:</strong> <?= $nif ?></p>
                            <?php endif; ?>
                            <hr>
                            <p><strong>Payment Method:</strong> <?= $paymentMethod->descricao ?></p>
                            <p><strong>Shipping Method:</strong> <?= $shippingMethod->descricao ?> (<?= $shippingMethod->duracao ?>)</p>
                            <p><strong>Shipping Cost:</strong> <?= $shippingMethod->preco == 0 ? 'Free' : $shippingMethod->preco . '€' ?></p>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="card mb-4 shadow-sm">
                        <div class="card-header bg-info text-white">Billing Information</div>
                        <div class="card-body">
                            <p><strong>Name:</strong> <?= $nome ?></p>
                            <p><strong>Address:</strong> <?= $morada ?></p>
                            <?php if ($phone != null): ?>
                            <p><strong>Phone:</strong> <?= $phone ?></p>
                            <?php endif; ?>
                            <?php if ($nif != null): ?>
                            <p><strong>NIF:</strong> <?= $nif ?></p>
                            <?php endif;?>
                        </div>
                    </div>
                    <div class="card shadow-sm">
                        <div class="card-header bg-success text-white">Payment & Shipping</div>
                        <div class="card-body">
                            <p><strong>Payment Method:</strong> <?= $paymentMethod->descricao ?></p>
                            <p><strong>Shipping Method:</strong> <?= $shippingMethod->descricao ?> (<?= $shippingMethod->duracao ?>)</p>
                            <p><strong>Shipping Cost:</strong> <?= $shippingMethod->preco == 0 ? 'Free' : $shippingMethod->preco . '€' ?></p>
                        </div>
                    </div>
                <?php endif; ?>

            </div>
        </div>
        <div class="text-center mt-4">
            <a href="<?= yii\helpers\Url::to(['fatura/index']) ?>" class="btn btn-outline-secondary me-3">
                <i class="fas fa-arrow-left"></i> Back to Checkout
            </a>
            <a href="<?= yii\helpers\Url::to(['fatura/confirm-order', 'shippingMethodId' => $shippingMethod->id, 'paymentMethodId' => $paymentMethod->id, 'fullName' => $nome, 'address' => $morada, 'phone' => $phone, 'nif' => $nif]) ?>" class="btn btn-success">
                <i class="fas fa-check"></i> Confirm and Pay
            </a>
        </div>
    </div>
</body>

</html>