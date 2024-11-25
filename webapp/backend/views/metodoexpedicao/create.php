<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Metodoexpedicao $model */

$this->title = 'Create Metodoexpedicao';
$this->params['breadcrumbs'][] = ['label' => 'Metodoexpedicaos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="metodoexpedicao-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
