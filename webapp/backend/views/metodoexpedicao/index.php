<?php

use common\models\Metodoexpedicao;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var backend\models\MetodoexpedicaoSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Expedition Methods';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="metodoexpedicao-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (Yii::$app->user->can('expeditionMethodCreate')): ?>
    <p>
        <?= Html::a('Create Expedition Method', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php endif; ?>
    
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'descricao',
            'preco',
            'duracao',
            'disponivel',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Metodoexpedicao $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 },
                 'visibleButtons' => [
                    'view' => function ($model, $key, $index) {
                        return Yii::$app->user->can('expeditionMethodView');
                    },
                    'update' => function ($model, $key, $index) {
                        return Yii::$app->user->can('expeditionMethodUpdate');
                    },
                    'delete' => function ($model, $key, $index) {
                        return Yii::$app->user->can('expeditionMethodDelete');
                    },
                ],
            ],
        ],
    ]); ?>


</div>
