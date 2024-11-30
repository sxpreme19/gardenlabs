<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var \frontend\models\UpdateUserForm $model */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Account Details';
?>
<!DOCTYPE html>
<html lang="en">
<!-- Basic -->

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Site Metas -->
    <title>ThewayShop - Ecommerce Bootstrap 4 HTML Template</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">

    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>
    <!-- Start All Title Box -->
    <div class="all-title-box">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h2>Account Details</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href=<?= yii\helpers\Url::to(['site/my-account']) ?>>My-Account</a></li>
                        <li class="breadcrumb-item active">Account Details</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- End All Title Box -->

    <!-- Start Cart  -->
    <div class="cart-box-main">
        <div class="container">
            <div class="row new-account-login">
                <div class="col-12 mb-4">
                    <div class="title-left">
                        <h3>Your Details</h3>
                    </div>
                </div>

                <?php $form = ActiveForm::begin(['id' => 'form-update-user']); ?>

                <div class="row"> 
                    <div class="col-sm-6 col-lg-6 mb-3">
                        <?= $form->field($model, 'username')->textInput([
                            'autofocus' => true,
                            'value' => Yii::$app->user->identity->username
                        ]) ?>

                        <?= $form->field($model, 'email')->input('email', [
                            'value' => Yii::$app->user->identity->email
                        ]) ?>
                        <?= $form->field($model, 'password')->passwordInput() ?>
                    </div>

                    <div class="col-sm-6 col-lg-6 mb-3">
                        <?= $form->field($model, 'nome')->textInput([
                            'value' => isset($userProfile->nome) ? $userProfile->nome : '',
                        ]) ?>
                        <?= $form->field($model, 'telefone')->textInput([
                            'value' => isset($userProfile->telefone) ? $userProfile->telefone : '',
                        ]) ?>
                        <?= $form->field($model, 'nif')->textInput([
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

    <!-- End Cart -->

    <!-- ALL JS FILES -->
    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <!-- ALL PLUGINS -->
    <script src="js/jquery.superslides.min.js"></script>
    <script src="js/bootstrap-select.js"></script>
    <script src="js/inewsticker.js"></script>
    <script src="js/bootsnav.js."></script>
    <script src="js/images-loded.min.js"></script>
    <script src="js/isotope.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/baguetteBox.min.js"></script>
    <script src="js/form-validator.min.js"></script>
    <script src="js/contact-form-script.js"></script>
    <script src="js/custom.js"></script>
</body>

</html>