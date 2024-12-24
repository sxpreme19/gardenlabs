<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Linhacarrinhoservico $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="linhacarrinhoservico-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'preco')->textInput() ?>

    <?= $form->field($model, 'carrinhoservico_id')->textInput() ?>

    <?= $form->field($model, 'servico_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
