<?php

use common\models\Linhafatura;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var backend\models\LinhafaturaSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Invoice Lines';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="linhafatura-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (Yii::$app->user->can('invoiceLineCreate')): ?>
    <p>
        <?= Html::a('Create Invoice Line', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php endif;?>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'quantidade',
            'precounitario',
            'fatura_id',
            //'produto_id',
            //'servico_id',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Linhafatura $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 },
                 'template' => '{view} ',
                 'visibleButtons' => [
                    'view' => function ($model, $key, $index) {
                        return Yii::$app->user->can('invoiceLineView');
                    },
                    'update' => function ($model, $key, $index) {
                        return Yii::$app->user->can('invoiceLineUpdate');
                    },
                    'delete' => function ($model, $key, $index) {
                        return Yii::$app->user->can('invoiceLineDelete');
                    },
                ],
            ],
        ],
    ]); ?>


</div>
