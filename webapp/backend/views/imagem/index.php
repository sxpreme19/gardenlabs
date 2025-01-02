    <?php

    use common\models\Imagem;
    use yii\helpers\Html;
    use yii\helpers\Url;
    use yii\grid\ActionColumn;
    use yii\grid\GridView;

    /** @var yii\web\View $this */
    /** @var backend\models\ImagemSearch $searchModel */
    /** @var yii\data\ActiveDataProvider $dataProvider */

    $this->title = 'Images';
    $this->params['breadcrumbs'][] = $this->title;
    ?>
    <div class="imagem-index">

        <h1><?= Html::encode($this->title) ?></h1>

        <?php // echo $this->render('_search', ['model' => $searchModel]); 
        ?>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'id',
                'filename',
                [
                    'attribute' => 'produto_id',
                    'value' => function ($model) {
                        return $model->produto ? $model->produto->nome : null;
                    },
                    'label' => 'Product',
                ],
                [
                    'class' => ActionColumn::className(),
                    'urlCreator' => function ($action, Imagem $model, $key, $index, $column) {
                        return Url::toRoute([$action, 'id' => $model->id]);
                    },
                    'template' => '{view} {delete}',
                    'visibleButtons' => [
                        'view' => function ($model, $key, $index) {
                            return Yii::$app->user->can('viewImage');
                        },
                        'delete' => function ($model, $key, $index) {
                            return Yii::$app->user->can('deleteImage');
                        },
                    ],
                ],
            ],
        ]); ?>


    </div>