<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Categoria;
use common\models\Fornecedor;

/** @var yii\web\View $this */
/** @var common\models\Produto $model */
/** @var yii\widgets\ActiveForm $form */

?>

<div class="row">
    <div class="col-lg-5">
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

        <?= $form->field($model, 'nome')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'descricao')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'preco')->textInput(['type' => 'number','step' => '0.01','min' => '0.01']) ?>

        <?= $form->field($model, 'quantidade')->textInput(['type' => 'number','step' => '1','min' => '1']) ?>

        <?= $form->field($model, 'categoria_id')->dropDownList(
            \yii\helpers\ArrayHelper::map(Categoria::find()->all(), 'id', 'nome'), 
            ['prompt' => 'Select a Categoria']
        ) ?>

        <?= $form->field($model, 'fornecedor_id')->dropDownList(
            \yii\helpers\ArrayHelper::map(Fornecedor::find()->all(), 'id', 'nome'), 
            ['prompt' => 'Select a Fornecedor']
        ) ?>

        <div class="form-group">
            <?= Html::submitButton('Save and Add Images', [
                'class' => 'btn btn-primary',
                'name' => 'add_images',
                'value' => 'yes',
            ]) ?>

            <?= Html::submitButton('Save and Go to Product Details', [
                'class' => 'btn btn-success',
                'name' => 'add_images',
                'value' => 'no',
            ]) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>  