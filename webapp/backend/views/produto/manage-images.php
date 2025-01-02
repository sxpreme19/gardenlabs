<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use common\models\Imagem;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var Produto $product */
/** @var Imagem $imageModel */
/** @var yii\data\ActiveDataProvider $imageDataProvider */

?>

<h1><?= Html::encode($this->title) ?></h1>

<h3>Upload a New Image</h3>

<?php if (Yii::$app->user->can('uploadImages')): ?>
    <div class="form-group">
        <?= Html::a('Upload Image', ['imagem/upload', 'id' => $produto_id], ['class' => 'btn btn-success']) ?>
    </div>
<?php endif; ?>

<h3>Existing Images</h3>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        'id',
        'filename',
        [
            'class' => 'yii\grid\ActionColumn',
            'urlCreator' => function ($action, Imagem $model, $key, $index, $column) {
                return Url::toRoute(['imagem/' . $action, 'id' => $model->id]);
            },
            'template' => '{view} {delete}',
            'visibleButtons' => [
                'view' => function ($model, $key, $index) {
                    return Yii::$app->user->can('viewImage');
                },
                'delete' => function ($model, $key, $index) {
                    return Yii::$app->user->can('deleteImage');
                },
            ],
        ],
    ],
]); ?>