<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Carrinhoservico $model */

$this->title = 'Update Carrinhoservico: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Carrinhoservicos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="carrinhoservico-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
