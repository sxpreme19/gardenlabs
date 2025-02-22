<?php

use common\models\Servico;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var backend\models\ServicoSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Services';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="servico-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (Yii::$app->user->can('deleteService')): ?>
        <p>
            <?= Html::a('Create Service', ['create'], ['class' => 'btn btn-success']) ?>
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
            'titulo',
            'descricao',
            'preco',
            'duracao',
            'prestador_id',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Servico $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                },
                'visibleButtons' => [
                    'view' => function ($model, $key, $index) {
                        return Yii::$app->user->can('viewService');
                    },
                    'update' => function ($model, $key, $index) {
                        return Yii::$app->user->can('editService');
                    },
                    'delete' => function ($model, $key, $index) {
                        return Yii::$app->user->can('deleteService');
                    },
                ],
            ],
        ],
    ]); ?>


</div>