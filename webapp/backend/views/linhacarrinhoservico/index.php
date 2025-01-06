<?php

use common\models\Linhacarrinhoservico;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var backend\models\LinhacarrinhoservicoSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Service Carts Lines';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="linhacarrinhoservico-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (Yii::$app->user->can('serviceCartLineCreate')): ?>
    <p>
        <?= Html::a('Create Service Cart Line', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php endif;?>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

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
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Linhacarrinhoservico $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 },
                 'visibleButtons' => [
                    'view' => function ($model, $key, $index) {
                        return Yii::$app->user->can('serviceCartLineView');
                    },
                    'update' => function ($model, $key, $index) {
                        return Yii::$app->user->can('serviceCartLineUpdate');
                    },
                    'delete' => function ($model, $key, $index) {
                        return Yii::$app->user->can('serviceCartLineDelete');
                    },
                ],
            ],
        ],
    ]); ?>


</div>
