<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Linhacarrinhoproduto $model */

$this->title = 'Update Linhacarrinhoproduto: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Linhacarrinhoprodutos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="linhacarrinhoproduto-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
