<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Linhacarrinhoservico $model */

$this->title = 'Create Linhacarrinhoservico';
$this->params['breadcrumbs'][] = ['label' => 'Linhacarrinhoservicos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="linhacarrinhoservico-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
