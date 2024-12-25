<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Metodoexpedicao $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="row">
    <div class="col-lg-5">
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'descricao')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'preco')->textInput() ?>

        <?= $form->field($model, 'duracao')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'disponivel')->checkbox() ?>

        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>