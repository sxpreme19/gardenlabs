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
<div class="fatura-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php if (Yii::$app->user->can('invoiceUpdate')): ?>
            <?= Html::a('Update', ['update', 'id' => $model->id, 'userprofile_id' => $model->userprofile_id], ['class' => 'btn btn-primary']) ?>
        <?php endif; ?>
        <?php if (Yii::$app->user->can('invoiceDelete')): ?>
            <?= Html::a('Delete', ['delete', 'id' => $model->id, 'userprofile_id' => $model->userprofile_id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?>
        <?php endif; ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'total',
            'datahora',
            'nome_destinatario',
            'morada_destinatario',
            'telefone_destinatario',
            'nif_destinatario',
            'preco_envio',
            [
                'attribute' => 'metodopagamento_id',
                'value' => $model->metodopagamento ? $model->metodopagamento->descricao : null,
                'label' => 'Payment Method',
            ],
            [
                'attribute' => 'metodoexpedicao_id',
                'value' => $model->metodoexpedicao ? $model->metodoexpedicao->descricao : null,
                'label' => 'Shipping Method',
            ],
            'userprofile_id',
        ],
    ]) ?>

</div>