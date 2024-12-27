<?php

use common\models\Userprofile;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var backend\models\UserprofileSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'User Profiles';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="userprofile-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (Yii::$app->user->can('createUserProfile')): ?>
    <p>
        <?= Html::a('Create Userprofile', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php endif;?>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'nome',
            'morada',
            'nif',
            'telefone',
            [
                'attribute' => 'user_id',
                'label' => 'User', 
                'value' => function ($model) {
                    return $model->user ? $model->user->username : null; 
                },
            ],
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Userprofile $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 },
                 'visibleButtons' => [
                    'view' => function ($model, $key, $index) {
                        return Yii::$app->user->can('viewUserProfile');
                    },
                    'update' => function ($model, $key, $index) {
                        return Yii::$app->user->can('updateUserProfile');
                    },
                    'delete' => function ($model, $key, $index) {
                        return Yii::$app->user->can('deleteUserProfile');
                    },
                ],
            ],
        ],
    ]); ?>


</div>
