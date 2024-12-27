<?php

use common\models\Produto;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var backend\models\ProdutoSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Produtos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="produto-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (Yii::$app->user->can('createProduct')): ?>
    <p>
        <?= Html::a('Create Produto', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>
    <?php endif;?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'nome',
            'descricao',
            'preco',
            'quantidade',
            [
                'attribute' => 'categoria_id',
                'value' => function ($model) {
                    return $model->categoria ? $model->categoria->nome : null; 
                },
                'label' => 'Category',
                'filter' => \yii\helpers\ArrayHelper::map(\common\models\Categoria::find()->all(), 'id', 'nome'),
            ],
            [
                'attribute' => 'fornecedor_id',
                'value' => function ($model) {
                    return $model->fornecedor ? $model->fornecedor->nome : null;
                },
                'label' => 'Supplier',
                'filter' => \yii\helpers\ArrayHelper::map(\common\models\Fornecedor::find()->all(), 'id', 'nome'),
            ],
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Produto $model, $key, $index, $column) {
                    if ($action === 'images') {
                        return Url::toRoute(['produto/manage-images', 'id' => $model->id]);
                    }
                    return Url::toRoute([$action, 'id' => $model->id]);
                },
                'template' => '{view} {update} {delete} {images} ',
                'buttons' => [
                    'images' => function ($url, $model) {
                        return Html::a('<i class="fas fa-images"></i>', $url, [
                            'title' => 'Manage Images',
                            'style' => 'padding: 0; margin: 0; line-height: 2;',
                            'data-toggle' => 'tooltip',
                        ]);
                    },
                ],
                'visibleButtons' => [
                    'view' => function ($model, $key, $index) {
                        return Yii::$app->user->can('viewProduct');
                    },
                    'update' => function ($model, $key, $index) {
                        return Yii::$app->user->can('editProduct');
                    },
                    'delete' => function ($model, $key, $index) {
                        return Yii::$app->user->can('deleteProduct');
                    },
                    'images' => function ($model, $key, $index) {
                        return Yii::$app->user->can('manageProductImages');
                    },
                ],
            ],
        ],
    ]); ?>


</div>