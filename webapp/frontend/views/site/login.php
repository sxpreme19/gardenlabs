<?php
/** @var yii\bootstrap5\ActiveForm $form */
/** @var \common\models\LoginForm $model */
use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;
?>
<div class="site-login">
    <!-- Login Form -->
    <br>
    <h1>Please fill out the following fields to login:</h1>
    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'password')->passwordInput() ?>

                <?= $form->field($model, 'rememberMe')->checkbox() ?>

                <div class="my-1 mx-0" style="color:#999;">
                    Don´t have an account? <?= Html::a('Sign up', ['site/signup']) ?>.
                    <br>
                    If you forgot your password you can <?= Html::a('reset it', ['site/request-password-reset']) ?>.
                    <br>
                    Need new verification email? <?= Html::a('Resend', ['site/resend-verification-email']) ?>
                </div>

                <div class="form-group">
                    <?= Html::submitButton('Login', ['class' => 'btn btn-success', 'name' => 'login-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
