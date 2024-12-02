<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Prestador $model */

$this->title = 'Create Prestador';
$this->params['breadcrumbs'][] = ['label' => 'Prestadors', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="prestador-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
