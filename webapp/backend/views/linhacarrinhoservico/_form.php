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

        <?= $form->field($model, 'preco')->textInput() ?>

        <?= $form->field($model, 'carrinhoservico_id')->textInput() ?>

        <?= $form->field($model, 'servico_id')->dropDownList(
            \yii\helpers\ArrayHelper::map(\common\models\Servico::find()->all(), 'id', 'nome'),
            ['prompt' => 'Select a Service']
        ) ?>

        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>