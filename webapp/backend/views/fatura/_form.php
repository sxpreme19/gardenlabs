<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Fatura $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="fatura-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'total')->textInput() ?>

    <?= $form->field($model, 'datahora')->textInput() ?>

    <?= $form->field($model, 'nome_destinatario')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'morada_destinatario')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'telefone_destinatario')->textInput() ?>

    <?= $form->field($model, 'nif_destinatario')->textInput() ?>

    <?= $form->field($model, 'metodopagamento_id')->textInput() ?>

    <?= $form->field($model, 'metodoexpedicao_id')->textInput() ?>

    <?= $form->field($model, 'userprofile_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
