<?php

use yii\widgets\LinkPager;
?>
<!DOCTYPE html>
<html lang="en">
<!-- Basic -->

<body>
    <!-- Start Gallery  -->
    <div class="products-box">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="title-all text-center">
                        <h1>Our Gallery</h1>
                        <h3>Feel free to explore our <b><?= $productTotalCount ?></b> products!</h3>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="special-menu text-center">
                        <div class="button-group filter-button-group">
                            <a href="<?= yii\helpers\Url::to(['produto/gallery', 'categoria_id' => null]) ?>"
                                class="btn <?= Yii::$app->request->get('categoria_id') === null ? 'btn-success active' : 'btn-light' ?>"
                                role="button">
                                All
                            </a>
                            <?php foreach ($categories as $category): ?>
                                <a href="<?= yii\helpers\Url::to(['produto/gallery', 'categoria_id' => $category->id]) ?>"
                                    class="btn <?= Yii::$app->request->get('categoria_id') == $category->id ? 'btn-success active' : 'btn-light' ?>"
                                    role="button">
                                    <?= $category->nome ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row special-list">
                <?php foreach ($dataProvider->models as $product): ?>
                    <div class="col-lg-3 col-md-6 special-grid">
                        <div class="products-single fix">
                            <div class="box-img-hover">
                                <div class="type-lb">
                                    <p class="sale">Sale</p>
                                </div>
                                <?php
                                $productImages = $product->imagems;
                                if (!empty($productImages)):
                                    $firstImage = $productImages[0];
                                ?>
                                    <img src="<?= yii\helpers\Url::to('../../backend/web/uploads/' . $firstImage->filename) ?>" class="img-fluid" alt="Image">
                                <?php endif; ?>
                                <div class="mask-icon">
                                    <ul>
                                        <li><a href=<?= yii\helpers\Url::to(['produto/product-details', 'id' => $product->id]) ?> data-toggle="tooltip" data-placement="right" title="View"><i class="fas fa-eye"></i></a></li>
                                        <li><a href="#" data-toggle="tooltip" data-placement="right" title="Add to Wishlist"><i class="far fa-heart"></i></a></li>
                                    </ul>
                                    <a class="cart" href="#">Add to Cart</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="pagination-container">
                <?php
                echo LinkPager::widget([
                    'pagination' => $dataProvider->pagination,
                    'options' => [
                        'class' => 'pagination justify-content-center'
                    ],
                    'linkOptions' => [
                        'class' => 'page-link',
                    ],
                    'prevPageLabel' => '&laquo;', 
                    'nextPageLabel' => '&raquo;', 
                    'disabledListItemSubTagOptions' => ['tag' => 'span', 'class' => 'page-link'], 
                ]);
                ?>
            </div>
        </div>
    </div>
    <!-- End Gallery  -->

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