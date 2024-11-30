<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\User $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="user-form">

    <?php 
        $data=['client'=>'Client','manager'=>'Manager','admin'=>'Admin']; 
    ?>
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'status')->textInput() ?>
    <?= Html::label('Role', 'roleDropDown', ['class' => 'control-label']) ?>
    <?= Html::dropDownList('roleDropDown',null,$data,[   
        'class' => 'form-control',
        'id' => 'roleDropDown', 
    ]);
    ?>
    <br>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
