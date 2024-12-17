<?php
/** @var yii\bootstrap5\ActiveForm $form */
/** @var \frontend\models\SignupForm $model */
use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;
?>
<div class="site-signup">
    <h1>Please fill out the following fields to signup:</h1>
    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

                <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'email') ?>

                <?= $form->field($model, 'password')->passwordInput() ?>

                <div class="form-group">
                    <?= Html::submitButton('Signup', ['class' => 'btn btn-success', 'name' => 'signup-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
