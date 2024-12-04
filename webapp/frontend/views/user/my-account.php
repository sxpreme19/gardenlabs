<?php

use yii\helpers\Html;
?>
<!DOCTYPE html>
<html lang="en">
<!-- Basic -->

<body>
    <!-- Start Cart  -->
    <div class="cart-box-main">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="title-left mb-4">
                        <h3 class="fw-bold">User Details</h3>
                    </div>
                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-header bg-dark">
                            <h5 class="mb-0 fw-medium" style="color:white">Personal Information</h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <tbody>
                                        <tr>
                                            <td class="fw-semibold"><i class="fas fa-user-circle me-2"></i>Username</td>
                                            <td><?= Html::encode(Yii::$app->user->identity->username) ?></td>
                                        </tr>
                                        <tr>
                                            <td class="fw-semibold"><i class="fas fa-envelope me-2"></i>Email</td>
                                            <td><?= Html::encode(Yii::$app->user->identity->email) ?></td>
                                        </tr>
                                        <tr>
                                            <td class="fw-semibold"><i class="fas fa-id-card me-2"></i>Name</td>
                                            <td><?= Html::encode($userProfile->nome ?? 'N/A') ?></td>
                                        </tr>
                                        <tr>
                                            <td class="fw-semibold"><i class="fas fa-phone me-2"></i>Telefone</td>
                                            <td><?= Html::encode($userProfile->telefone ?? 'N/A') ?></td>
                                        </tr>
                                        <tr>
                                            <td class="fw-semibold"><i class="fas fa-passport me-2"></i>NIF</td>
                                            <td><?= Html::encode($userProfile->nif ?? 'N/A') ?></td>
                                        </tr>
                                        <tr>
                                            <td class="fw-semibold"><i class="fas fa-map-marker-alt me-2"></i>Morada</td>
                                            <td><?= Html::encode($userProfile->morada ?? 'N/A') ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="mt-3">
                            <a href=<?=\yii\helpers\Url::to(['user/account-details'])?> class="btn btn-success">Edit Details</a>
                            <?= Html::a('Delete', ['user/delete', 'id' => Yii::$app->user->identity->id], [
                                'class' => 'btn btn-danger',
                                'data' => [
                                    'method' => 'post',
                                    'confirm' => 'Are you sure you want to delete this item?',
                                ],
                            ]) ?>
                        </div>
                    </div>
                </div>
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