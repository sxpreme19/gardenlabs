<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;
?>
<!DOCTYPE html>
<html lang="en">
<body>
    <!-- Card Container -->
    <?php if (empty($dataProvider->models)): ?>
        <div class="alert alert-info text-center shadow-sm rounded p-4">
            <div class="mb-4">
                <i class="fas fa-info-circle fa-3x text-primary"></i>
            </div>
            <h5 class="display-6 text-primary mb-3">No Invoices Found</h5>
            <p class="text-muted" style="font-size: 1.25rem;">
                It seems there are no invoices available at the moment. Feel free to explore our
                <a href="<?= \yii\helpers\Url::to(['produto/index']) ?>" class="text-primary font-weight-bold">Product Store</a> and find something you'll love!
            </p>
        </div>
    <?php else: ?>
        <div class="row">
            <?php foreach ($dataProvider->models as $fatura): ?>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card shadow-sm border-light rounded">
                        <div class="card-body">
                            <h5 class="card-title">#<?= Html::encode($fatura->id) ?> - <?= Yii::$app->formatter->asDate($fatura->datahora, 'php:d/m/Y') ?></h5>
                            <p class="card-text"><strong>Total:</strong> <?= Yii::$app->formatter->asCurrency($fatura->total) ?></p>
                            <p class="card-text"><strong>Método de Pagamento:</strong>
                                <?= $fatura->metodopagamento ? Html::encode($fatura->metodopagamento->descricao) : 'Não informado' ?>
                            </p>
                            <p class="card-text"><strong>Método de Expedição:</strong>
                                <?= $fatura->metodoexpedicao ? Html::encode($fatura->metodoexpedicao->descricao) : 'Não informado' ?>
                            </p>
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="<?= \yii\helpers\Url::to(['purchase-details', 'id' => $fatura->id]) ?>" class="btn btn-primary btn-sm">
                                    <i class="fas fa-eye"></i> Detalhes
                                </a>
                                <small class="text-muted"><?= Yii::$app->formatter->asDatetime($fatura->datahora, 'php:H:i') ?></small>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="pagination-container">
            <?php
            echo LinkPager::widget([
                'pagination' => $dataProvider->pagination,
                'options' => [
                    'class' => 'pagination justify-content-center'
                ],
                'linkOptions' => [
                    'class' => 'page-link',
                ],
                'prevPageLabel' => '&laquo;',
                'nextPageLabel' => '&raquo;',
                'disabledListItemSubTagOptions' => ['tag' => 'span', 'class' => 'page-link'],
            ]);
            ?>
        </div>
    <?php endif; ?>
</body>

</html>