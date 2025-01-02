<?php

use common\models\Metodopagamento;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var backend\models\MetodopagamentoSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Payment Methods';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="metodopagamento-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (Yii::$app->user->can('paymentMethodCreate')): ?>
    <p>
        <?= Html::a('Create Payment Method', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php endif;?>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'descricao',
            'disponivel',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Metodopagamento $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 },
                 'visibleButtons' => [
                    'view' => function ($model, $key, $index) {
                        return Yii::$app->user->can('paymentMethodView');
                    },
                    'update' => function ($model, $key, $index) {
                        return Yii::$app->user->can('paymentMethodUpdate');
                    },
                    'delete' => function ($model, $key, $index) {
                        return Yii::$app->user->can('paymentMethodDelete');
                    },
                ],
            ],
        ],
    ]); ?>


</div>
