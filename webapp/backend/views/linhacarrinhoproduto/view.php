<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Linhacarrinhoproduto $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Linhacarrinhoprodutos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="linhacarrinhoproduto-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php if (Yii::$app->user->can('productCartLineUpdate')): ?>
            <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php endif; ?>
        <?php if (Yii::$app->user->can('productCartLineDelete')): ?>
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
            'quantidade',
            'precounitario',
            'carrinhoproduto_id',
            [
                'attribute' => 'produto_id',
                'value' => function ($model) {
                    return $model->produto ? $model->produto->nome : 'No product';
                },
                'label' => 'Product',
            ],
        ],
    ]) ?>

</div>