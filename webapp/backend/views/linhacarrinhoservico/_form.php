<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Linhacarrinhoservico $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="row">
    <div class="col-lg-5">
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'preco')->textInput(['type' => 'number', 'step' => '0.01','min' => '0']) ?>

        <?= $form->field($model, 'carrinhoservico_id')->textInput(['type' => 'number', 'step' => '1','min' => '1']) ?>

        <?= $form->field($model, 'servico_id')->dropDownList(
            \yii\helpers\ArrayHelper::map(\common\models\Servico::find()->all(), 'id', 'titulo'),
            ['prompt' => 'Select a Service']
        ) ?>

        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>