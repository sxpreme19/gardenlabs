<?php
/** @var yii\bootstrap5\ActiveForm $form */
/** @var \common\models\ResetPasswordForm $model */
use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;
?>
<div class="site-reset-password">
    <p>Please enter your email, your old password, and choose your new password:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'reset-password-form']); ?>

                <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>
                <?= $form->field($model, 'oldPassword')->passwordInput() ?>
                <?= $form->field($model, 'password')->passwordInput() ?>
                <?= $form->field($model, 'confirmPassword')->passwordInput() ?>

                <div class="form-group">
                    <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
