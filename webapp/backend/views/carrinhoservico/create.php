<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Carrinhoservico $model */

$this->title = 'Create Carrinhoservico';
$this->params['breadcrumbs'][] = ['label' => 'Carrinhoservicos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="carrinhoservico-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
