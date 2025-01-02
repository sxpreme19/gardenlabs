<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var common\models\Imagem $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Imagems', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="imagem-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (Yii::$app->user->can('deleteImage')): ?>
    <p>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <?php endif; ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'filename',
            [
                'attribute' => 'produto_id',
                'value' => $model->produto ? $model->produto->nome : null, 
                'label' => 'Product',
            ],
        ],
    ]) ?>

<h3>Image Preview:</h3>
    <div>
        <?= Html::img(Url::to('@web/uploads/' . $model->filename), ['alt' => 'Image', 'class' => 'img-fluid', 'style' => 'max-width: 50%; height: auto;']) ?>
    </div>

</div>
