<?php
/** @var yii\bootstrap5\ActiveForm $form */
/** @var \frontend\models\UpdateUserForm $model */
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
?>
<!DOCTYPE html>
<html lang="en">
<!-- Basic -->
<body>
    <!-- Start Cart  -->
    <div class="cart-box-main">
        <div class="container">
            <div class="row new-account-login">
                <div class="col-12 mb-4">
                    <div class="title-left">
                        <h3>Edit Details</h3>
                    </div>
                </div>

                <?php $form = ActiveForm::begin(['id' => 'form-update-user']); ?>

                <div class="row"> 
                    <div class="col-sm-6 col-lg-6 mb-3">
                        <?= $form->field($model, 'username')->textInput([
                            'autofocus' => true,
                            'value' => Html::encode(Yii::$app->user->identity->username)
                        ]) ?>

                        <?= $form->field($model, 'email')->input('email', [
                            'value' => Html::encode(Yii::$app->user->identity->email)
                        ]) ?>
                        <?= $form->field($model, 'password')->passwordInput()->label("Password (Leave blank to maintain password)") ?>
                    </div>

                    <div class="col-sm-6 col-lg-6 mb-3">
                        <?= $form->field($model, 'nome')->textInput([
                            'value' => isset($userProfile->nome) ? $userProfile->nome : '',
                        ]) ?>
                        <?= $form->field($model, 'telefone')->textInput([
                            'maxlength' => 9,
                            'value' => isset($userProfile->telefone) ? $userProfile->telefone : '',
                        ]) ?>
                        <?= $form->field($model, 'nif')->textInput([
                            'maxlength' => 9,
                            'value' => isset($userProfile->nif) ? $userProfile->nif : '',
                        ]) ?>
                        
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mb-4">
                        <?= $form->field($model, 'morada')->textInput([
                            'value' => isset($userProfile->morada) ? $userProfile->morada : '',
                        ]) ?>
                    </div>
                </div>

                <div class="col-12 text-center mt-4">
                    <?= Html::submitButton('Update', ['class' => 'btn btn-success', 'name' => 'update-button']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</body>

</html>