<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Linhacarrinhoproduto $model */

$this->title = 'Create Linhacarrinhoproduto';
$this->params['breadcrumbs'][] = ['label' => 'Linhacarrinhoprodutos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="linhacarrinhoproduto-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
