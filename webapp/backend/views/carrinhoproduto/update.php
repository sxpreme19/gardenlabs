<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Carrinhoproduto $model */

$this->title = 'Update Carrinhoproduto: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Carrinhoprodutos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="carrinhoproduto-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
