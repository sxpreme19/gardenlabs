<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\ProdutoSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="produto-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'descricao') ?>

    <?= $form->field($model, 'preco') ?>

    <?= $form->field($model, 'nome') ?>

    <?= $form->field($model, 'quantidade') ?>

    <?php // echo $form->field($model, 'categoria_id') ?>

    <?php // echo $form->field($model, 'fornecedor_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
