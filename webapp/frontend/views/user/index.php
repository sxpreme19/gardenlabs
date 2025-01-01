<!DOCTYPE html>
<html lang="en">
<!-- Basic -->
<body>
    <!-- Start My Account  -->
    <div class="my-account-box-main">
        <div class="container">
            <div class="my-account-page">
                <div class="row">
                    <?php if(Yii::$app->user->can('ordersHistory')): ?>
                    <div class="col-lg-4 col-md-12">
                        <div class="account-box">
                            <div class="service-box">
                                <div class="service-icon">
                                    <a href="<?=yii\helpers\Url::to(['user/purchase-history'])?>"> <i class="fa fa-gift"></i> </a>
                                </div>
                                <div class="service-desc">
                                    <h4>Your Orders</h4>
                                    <p>Track your purchase history</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                    <?php if(Yii::$app->user->can('accountDetails')): ?>
                    <div class="col-lg-4 col-md-12">
                        <div class="account-box">
                            <div class="service-box">
                                <div class="service-icon">
                                    <a href=<?=yii\helpers\Url::to(['user/my-account'])?>><i class="fa fa-lock"></i> </a>
                                </div>
                                <div class="service-desc">
                                    <h4>Account details</h4>
                                    <p>View account details</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif;?>
                    <div class="col-lg-4 col-md-12">
                        <div class="account-box">
                            <div class="service-box">
                                <div class="service-icon">
                                    <a href="<?=yii\helpers\Url::to(['favorito/index'])?>"> <i class="fa fa-heart"></i> </a>
                                </div>
                                <div class="service-desc">
                                    <h4>Your Wishlist</h4>
                                    <p>View and manage your favorite products</p>
                                </div>
                            </div>
                        </div>
                    </div>                 
                </div>
            </div>
        </div>
    </div>
    <!-- End My Account -->
</body>

</html>