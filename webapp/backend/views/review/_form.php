<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Review $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="row">
    <div class="col-lg-5">
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'conteudo')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'datahora')->textInput(['type' => 'datetime-local']) ?>

        <?= $form->field($model, 'avaliacao')->textInput(['type' => 'number', 'step' => '0.01','min' => '0']) ?>

        <?= $form->field($model, 'servico_id')->dropDownList(
            \yii\helpers\ArrayHelper::map(\common\models\Servico::find()->all(), 'id', 'nome'), 
            ['prompt' => 'Select Service']
        ) ?>

        <?= $form->field($model, 'produto_id')->dropDownList(
            \yii\helpers\ArrayHelper::map(\common\models\Produto::find()->all(), 'id', 'nome'),
            ['prompt' => 'Select Product']
        ) ?>

        <?= $form->field($model, 'userprofile_id')->textInput(['type' => 'number', 'step' => '1','min' => '1']) ?>

        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>