<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Linhacarrinhoservico $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Linhacarrinhoservicos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="linhacarrinhoservico-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php if (Yii::$app->user->can('serviceCartLineUpdate')): ?>
            <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php endif; ?>
        <?php if (Yii::$app->user->can('serviceCartLineDelete')): ?>
            <?= Html::a('Delete', ['delete', 'id' => $model->id], [
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
            'preco',
            'carrinhoservico_id',
            [
                'attribute' => 'servico_id',
                'value' => function ($model) {
                    return $model->servico ? $model->servico->titulo : 'No service';
                },
                'label' => 'Service',
            ],
        ],
    ]) ?>

</div>