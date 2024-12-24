<?php

use common\models\Fatura;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\FaturaSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Invoices';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fatura-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Invoice', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'total',
            'datahora',
            'nome_destinatario',
            'morada_destinatario',
            //'telefone_destinatario',
            //'nif_destinatario',
            //'metodopagamento_id',
            //'metodoexpedicao_id',
            //'userprofile_id',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Fatura $model, $key, $index, $column) {
                    if ($action === 'invoiceLines') {
                        return Url::toRoute(['linhafatura/index', 'id' => $model->id]); 
                    }
                    return Url::toRoute([$action, 'id' => $model->id, 'userprofile_id' => $model->userprofile_id]);
                 },
                 'template' => '{view} {update} {delete} {invoiceLines} ', 
                 'buttons' => [
                     'invoiceLines' => function ($url, $model) {
                         return Html::a('<i class="fas fa-file-invoice"></i>', $url, [
                             'title' => 'Invoice Lines', 
                             'style' => 'padding: 0; margin: 0; line-height: 2;', 
                             'data-toggle' => 'tooltip', 
                         ]);
                     },
                 ],
            ],
        ],
    ]); ?>


</div>
