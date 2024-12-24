<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\forms\UpdateUserForm $model */
/** @var yii\widgets\ActiveForm $form */

$data = ['client' => 'Client', 'manager' => 'Manager', 'admin' => 'Admin', 'provider' => 'Provider'];
?>

<div class="user-form">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'status')->textInput() ?>

    <?= Html::label('Role', 'roleDropDown', ['class' => 'control-label']) ?>
    <?= Html::dropDownList('roleDropDown', null, $data, [
        'class' => 'form-control',
        'id' => 'roleDropDown',
    ]);
    ?>

    <br>
    <?= $form->field($model, 'new_password')->passwordInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'confirm_password')->passwordInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>