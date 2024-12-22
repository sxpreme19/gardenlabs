<!DOCTYPE html>
<html lang="en">

<body>
    <div class="container py-5">
        <div class="card shadow-lg mx-auto" style="max-width: 900px;">
            <div class="card-header bg-dark text-white text-center p-4">
                <h1 class="mb-0" style="color:white;font-size:33px">Invoice #<?= $invoice->id ?></h1>
                <p class="lead mb-0" style="color:white">Thank you for your order! Below are the details of your purchase.</p>
                <p class="small mb-0"><?= date('l, F j, Y', strtotime($invoice->datahora)) ?> at <?= date('g:i A', strtotime($invoice->datahora)) ?></p>
            </div>

            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-6">
                        <h4><strong>Billing Address</strong></h4>
                        <p><strong>Name:</strong> <?= $userProfile->nome ?></p>
                        <p><strong>Email:</strong> <?= Yii::$app->user->identity->email ?></p>
                        <p><strong>Address:</strong> <?= $userProfile->morada ?></p>
                        <p><strong>Phone:</strong> <?= $userProfile->telefone ?></p>
                        <p><strong>Nif:</strong> <?= $userProfile->nif ?></p>
                    </div>
                    <div class="col-6 text-end">
                        <h4><strong>Invoice Date</strong></h4>
                        <p><?= date('l, F j, Y', strtotime($invoice->datahora)) ?></p>
                        <p><?= date('g:i A', strtotime($invoice->datahora)) ?></p>
                    </div>
                </div>
                <div class="table-responsive mb-4">
                    <h4><strong>Order Summary</strong></h4>
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Unit Price</th>
                                <th class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($invoice->linhafaturas as $invoiceDetail): ?>
                                <tr>
                                    <td><?= $invoiceDetail->produto->nome ?></td>
                                    <td><?= $invoiceDetail->quantidade ?></td>
                                    <td><?= number_format($invoiceDetail->precounitario, 2) ?>€</td>
                                    <td class="text-end"><?= number_format($invoiceDetail->precounitario * $invoiceDetail->quantidade, 2) ?>€</td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="row mb-4">
                    <div class="col-6">
                        <h5><strong>Payment Method</strong></h5>
                        <p><?= $paymentMethod->descricao ?></p>
                    </div>
                    <div class="col-6 text-end">
                        <h5><strong>Shipping Method</strong></h5>
                        <p><?= $shippingMethod->descricao ?> (<?= $shippingMethod->duracao ?>)</p>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-6">
                        <p><strong>Subtotal:</strong></p>
                    </div>
                    <div class="col-6 text-end">
                        <p><?= number_format($invoice->total - $shippingMethod->preco, 2) ?>€</p>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-6">
                        <p><strong>Shipping Cost:</strong></p>
                    </div>
                    <div class="col-6 text-end">
                        <p><?= $shippingMethod->preco == 0 ? 'Free' : number_format($shippingMethod->preco, 2) . '€' ?></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <h4><strong>Grand Total</strong></h4>
                    </div>
                    <div class="col-6 text-end">
                        <h4 class="text-success"><?= number_format($invoice->total, 2) ?>€</h4>
                    </div>
                </div>
            </div>

            <div class="card-footer text-center">
                <a href="<?= yii\helpers\Url::to(['produto/index']) ?>" class="btn btn-outline-primary">
                    <i class="fas fa-arrow-left"></i> Back to Shop
                </a>
            </div>
        </div>
    </div>
</body>

</html>