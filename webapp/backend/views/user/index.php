<?php

use common\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var backend\models\UserSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (Yii::$app->user->can('createUserProfile')): ?>
        <p>
            <?= Html::a('Create User', ['create'], ['class' => 'btn btn-success']) ?>
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
            'username',
            //'auth_key',
            //'password_hash',
            //'password_reset_token',
            'email:email',
            'status',
            [
                'label' => 'Role',
                'value' => function ($model) {
                    $roles = Yii::$app->authManager->getRolesByUser($model->id);
                    return implode(', ', array_keys($roles));
                },
            ],
            //'created_at',
            //'updated_at',
            //'verification_token',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, User $model, $key, $index, $column) {
                    if ($action === 'userprofile') {
                        return Url::toRoute(['userprofile/index', 'id' => $model->id]);
                    }
                    return Url::toRoute([$action, 'id' => $model->id]);
                },
                'template' => '{view} {update} {delete} {userprofile} ',
                'buttons' => [
                    'userprofile' => function ($url, $model) {
                        return Html::a('<i class="fas fa-id-badge"></i>', $url, [
                            'title' => 'User Profile',
                            'style' => 'padding: 0; margin: 0; line-height: 2;',
                            'data-toggle' => 'tooltip',
                        ]);
                    },
                ],
                'visibleButtons' => [
                'view' => function ($model, $key, $index) {
                    return Yii::$app->user->can('viewUser');
                },
                'update' => function ($model, $key, $index) {
                    return Yii::$app->user->can('updateUser');
                },
                'delete' => function ($model, $key, $index) {
                    return Yii::$app->user->can('deleteUser');
                },
                'userprofile' => function ($model, $key, $index) {
                    return Yii::$app->user->can('usersProfilesIndex'); 
                },
            ],
            ],
        ],
    ]); ?>


</div>