<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\User $model */
/** @var yii\widgets\ActiveForm $form */

$data=['client'=>'Client','manager'=>'Manager','admin'=>'Admin']; 
?>
<div class="row">
    <div class="col-lg-5">
        <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'password')->passwordInput() ?>
            <?= Html::label('Role', 'roleDropDown', ['class' => 'control-label']) ?>
            <?= Html::dropDownList('roleDropDown',null,$data,[   
                'class' => 'form-control',
                'id' => 'roleDropDown', 
            ]);
            ?>
            <br>
            <div class="form-group">
                <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
            </div>
            
        <?php ActiveForm::end(); ?>
    </div>    
</div><!-- createForm -->
