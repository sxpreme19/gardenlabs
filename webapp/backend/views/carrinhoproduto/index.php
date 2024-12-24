<?php

use common\models\Carrinhoproduto;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var backend\models\CarrinhoprodutoSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Product Carts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="carrinhoproduto-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Product Cart', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>

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
                'urlCreator' => function ($action, Carrinhoproduto $model, $key, $index, $column) {
                    if ($action === 'linhacarrinhoproduto') {
                        return Url::toRoute(['linhacarrinhoproduto/index', 'id' => $model->id]);
                    }
                    return Url::toRoute([$action, 'id' => $model->id]);
                },
                'template' => '{view} {update} {delete} {linhacarrinhoproduto} ',
                'buttons' => [
                    'linhacarrinhoproduto' => function ($url, $model) {
                        return Html::a('<i class="fas fa-box-open"></i>', $url, [
                            'title' => 'LinhasCarrinho',
                            'style' => 'padding: 0; margin: 0; line-height: 2;',
                            'data-toggle' => 'tooltip',
                        ]);
                    },
                ],
            ],
        ],
    ]); ?>


</div>