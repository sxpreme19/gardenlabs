<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Servico $model */

$this->title = 'Update Servico: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Servicos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="servico-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
