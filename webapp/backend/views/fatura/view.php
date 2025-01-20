<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Fatura $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Faturas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="container py-5">
    <div class="card shadow-lg mx-auto" style="max-width: 900px;">
        <div class="card-header bg-dark text-white text-center p-4">
            <h1 class="mb-0" style="color:white;font-size:33px">Invoice #<?= $model->id ?></h1>
            <p class="small mb-0"><?= date('l, F j, Y', strtotime($model->datahora)) ?> at <?= date('g:i A', strtotime($model->datahora)) ?></p>
            <p class="small mb-0">User : <?= $user->username ?></p>
        </div>

        <div class="card-body">
            <div class="row mb-4">
                <div class="col-6">
                    <h4><strong>Billing Address</strong></h4>
                    <p><strong>Name:</strong> <?= $model->nome_destinatario ?></p>
                    <p><strong>Email:</strong> <?= Yii::$app->user->identity->email ?></p>
                    <p><strong>Address:</strong> <?= $model->morada_destinatario ?></p>
                    <?php if ($model->telefone_destinatario != null): ?>
                        <p><strong>Phone:</strong> <?= $model->telefone_destinatario ?></p>
                    <?php endif; ?>
                    <?php if ($model->nif_destinatario != null): ?>
                        <p><strong>Nif:</strong> <?= $model->nif_destinatario ?></p>
                    <?php endif; ?>
                </div>
                <div class="col-6 text-end">
                    <h4><strong>Invoice Date</strong></h4>
                    <p><?= date('l, F j, Y', strtotime($model->datahora)) ?></p>
                    <p><?= date('g:i A', strtotime($model->datahora)) ?></p>
                </div>
            </div>
            <div class="table-responsive mb-4">
                <h4><strong>Order Summary</strong></h4>
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <?php if($model->metodoexpedicao_id != null): ?>
                            <th>Product</th>
                            <?php else: ?>
                                <th>Service</th>
                            <?php endif; ?>
                            <th>Quantity</th>
                            <th>Unit Price</th>
                            <th class="text-end">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($model->linhafaturas as $modelDetail): ?>
                            <tr>
                                <?php if ($modelDetail->produto_id): ?>
                                    <td><?= $modelDetail->produto->nome ?></td>
                                    <td><?= $modelDetail->quantidade ?></td>
                                    <td><?= number_format($modelDetail->precounitario, 2) ?>€</td>
                                    <td class="text-end"><?= number_format($modelDetail->precounitario * $modelDetail->quantidade, 2) ?>€</td>
                                <?php elseif ($modelDetail->servico_id): ?>
                                    <td><?= $modelDetail->servico->titulo ?></td>
                                    <td>1</td>
                                    <td><?= number_format($modelDetail->servico->preco, 2) ?>€</td>
                                    <td class="text-end"><?= number_format($modelDetail->servico->preco, 2) ?>€</td>
                                <?php endif; ?>
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
                <?php if ($shippingMethod != null): ?>
                <div class="col-6 text-end">
                    <h5><strong>Shipping Method</strong></h5>
                    <p><?= $shippingMethod->descricao ?> (<?= $shippingMethod->duracao ?>)</p>
                </div>
                <?php endif;?>
            </div>
            <?php if ($shippingMethod != null): ?>
            <div class="row mb-4">
                <div class="col-6">
                    <p><strong>Subtotal:</strong></p>
                </div>
                <div class="col-6 text-end">
                    <p><?= number_format($model->total - $model->preco_envio, 2) ?>€</p>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-6">
                    <p><strong>Shipping Cost:</strong></p>
                </div>
                <div class="col-6 text-end">
                    <p><?= $model->preco_envio == 0 ? 'Free' : number_format($model->preco_envio, 2) . '€' ?></p>
                </div>
            </div>
            <?php endif;?>
            <div class="row">
                <div class="col-6">
                    <h4><strong>Grand Total</strong></h4>
                </div>
                <div class="col-6 text-end">
                    <h4 class="text-success"><?= number_format($model->total, 2) ?>€</h4>
                </div>
            </div>
        </div>
    </div>
</div>