<?php

use common\models\Produto;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var backend\models\ProdutoSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Produtos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="produto-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Produto', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'nome',
            'descricao',
            'preco',
            'quantidade',
            'categoria_id',
            'fornecedor_id',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Produto $model, $key, $index, $column) {
                    if ($action === 'images') {
                        return Url::toRoute(['produto/manage-images', 'id' => $model->id]); 
                    }
                    return Url::toRoute([$action, 'id' => $model->id]);
                },
                'template' => '{view} {update} {delete} {images} ', 
                'buttons' => [
                    'images' => function ($url, $model) {
                        return Html::a('<i class="fas fa-images"></i>', $url, [
                            'title' => 'Manage Images', 
                            'style' => 'padding: 0; margin: 0; line-height: 2;', 
                            'data-toggle' => 'tooltip', 
                        ]);
                    },
                ],
            ],
        ],
    ]); ?>


</div>