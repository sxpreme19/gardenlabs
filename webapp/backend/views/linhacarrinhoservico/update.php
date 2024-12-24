<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Linhacarrinhoservico $model */

$this->title = 'Update Linhacarrinhoservico: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Linhacarrinhoservicos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="linhacarrinhoservico-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
