<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Linhacarrinhoproduto $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="row">
    <div class="col-lg-5">
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'quantidade')->textInput(['type' => 'number', 'step' => '1','min' => '1']) ?>

        <?= $form->field($model, 'precounitario')->textInput(['type' => 'number', 'step' => '0.01','min' => '0']) ?>

        <?= $form->field($model, 'carrinhoproduto_id')->textInput(['type' => 'number', 'step' => '1','min' => '1']) ?>

        <?= $form->field($model, 'produto_id')->dropDownList(
            \yii\helpers\ArrayHelper::map(\common\models\Produto::find()->all(), 'id', 'nome'),
            ['prompt' => 'Select a Product']
        ) ?>

        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>