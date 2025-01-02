<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Fatura $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="row">
    <div class="col-lg-5">
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'total')->textInput(['type' => 'number','step' => '0.01','min' => '0']) ?>

        <?= $form->field($model, 'datahora')->textInput(['type' => 'datetime-local']) ?>

        <?= $form->field($model, 'nome_destinatario')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'morada_destinatario')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'telefone_destinatario')->textInput(['type' => 'number']) ?>

        <?= $form->field($model, 'nif_destinatario')->textInput(['type' => 'number']) ?>

        <?= $form->field($model, 'preco_envio')->textInput(['type' => 'number','step' => '0.01','min' => '0.01']) ?>

        <?= $form->field($model, 'metodopagamento_id')->dropDownList(
            \yii\helpers\ArrayHelper::map(\common\models\Metodopagamento::find()->all(), 'id', 'descricao'),
            ['prompt' => 'Select Payment Method']
        ) ?>

        <?= $form->field($model, 'metodoexpedicao_id')->dropDownList(
            \yii\helpers\ArrayHelper::map(\common\models\Metodoexpedicao::find()->all(), 'id', 'descricao'),
            ['prompt' => 'Select Shipping Method']
        ) ?>


        <?= $form->field($model, 'userprofile_id')->textInput(['type' => 'number','step' => '0.01','min' => '1']) ?>

        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>