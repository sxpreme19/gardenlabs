<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Fatura $model */

$this->title = 'Update Fatura: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Faturas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id, 'userprofile_id' => $model->userprofile_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="fatura-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
