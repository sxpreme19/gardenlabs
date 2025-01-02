<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Userprofile $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="row">
    <div class="col-lg-5">
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'nome')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'morada')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'nif')->textInput(['type' => 'number']) ?>

        <?= $form->field($model, 'telefone')->textInput(['type' => 'number']) ?>

        <?= $form->field($model, 'user_id')->dropDownList(
            \yii\helpers\ArrayHelper::map(\common\models\User::find()->all(), 'id', 'username'),
            ['prompt' => 'Select User']
        ) ?>

        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>