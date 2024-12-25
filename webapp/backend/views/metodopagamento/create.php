<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Metodopagamento $model */

$this->title = 'Create Payment Method';
$this->params['breadcrumbs'][] = ['label' => 'Metodopagamentos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="metodopagamento-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
