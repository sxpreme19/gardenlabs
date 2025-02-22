<?php

use common\models\Linhacarrinhoproduto;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var backend\models\LinhacarrinhoprodutoSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Product Cart Lines';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="linhacarrinhoproduto-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (Yii::$app->user->can('productCartLineCreate')): ?>
    <p>
        <?= Html::a('Create Product Cart Line', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php endif; ?>

    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

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
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Linhacarrinhoproduto $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                },
                'visibleButtons' => [
                   'view' => function ($model, $key, $index) {
                       return Yii::$app->user->can('productCartLineView');
                   },
                   'update' => function ($model, $key, $index) {
                       return Yii::$app->user->can('productCartLineUpdate');
                   },
                   'delete' => function ($model, $key, $index) {
                       return Yii::$app->user->can('productCartLineDelete');
                   },
               ],
            ],
        ],
    ]); ?>


</div>