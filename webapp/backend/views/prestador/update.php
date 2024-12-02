<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Prestador $model */

$this->title = 'Update Prestador: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Prestadors', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="prestador-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
