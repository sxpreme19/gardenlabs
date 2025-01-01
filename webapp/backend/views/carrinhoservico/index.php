<?php

use common\models\Carrinhoservico;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var backend\models\CarrinhoservicoSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Service Carts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="carrinhoservico-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (Yii::$app->user->can('serviceCartCreate')): ?>
    <p>
        <?= Html::a('Create Service Cart', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php endif;?>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'total',
            'userprofile_id',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Carrinhoservico $model, $key, $index, $column) {
                    if ($action === 'linhacarrinhoservico') {
                        return Url::toRoute(['linhacarrinhoservico/index', 'id' => $model->id]);
                    }
                    return Url::toRoute([$action, 'id' => $model->id]);
                 },
                 'template' => '{view} {update} {delete} {linhacarrinhoservico} ',
                 'buttons' => [
                     'linhacarrinhoservico' => function ($url, $model) {
                         return Html::a('<i class="fas fa-box-open"></i>', $url, [
                             'title' => 'LinhasCarrinho',
                             'style' => 'padding: 0; margin: 0; line-height: 2;',
                             'data-toggle' => 'tooltip',
                         ]);
                     },
                 ],
                 'visibleButtons' => [
                    'view' => function ($model, $key, $index) {
                        return Yii::$app->user->can('serviceCartView');
                    },
                    'update' => function ($model, $key, $index) {
                        return Yii::$app->user->can('serviceCartUpdate');
                    },
                    'delete' => function ($model, $key, $index) {
                        return Yii::$app->user->can('serviceCartDelete');
                    },
                    'linhacarrinhoproduto' => function ($model, $key, $index) {
                        return Yii::$app->user->can('serviceCartLinesIndex');
                    },
                ],
            ],
        ],
    ]); ?>


</div>
