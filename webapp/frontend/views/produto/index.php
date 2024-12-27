<?php

use yii\widgets\LinkPager;
?>
<!DOCTYPE html>
<html lang="en">
<!-- Basic -->

<body>
    <!-- Start Shop Page  -->
    <div class="shop-box-inner">
        <div class="container">
            <div class="row">
                <div class="col-xl-9 col-lg-9 col-sm-12 col-xs-12 shop-content-right">
                    <div class="right-product-box">
                        <div class="product-item-filter row">
                            <div class="col-12 col-sm-8 text-center text-sm-left">
                                <div class="toolbar-sorter-right">
                                    <span>Sort by </span>
                                    <select id="sort" class="selectpicker show-tick form-control" data-placeholder="$ USD">
                                        <option value="0" <?= isset($_GET['sort']) && $_GET['sort'] == '0' ? 'selected' : '' ?>>Nothing</option>
                                        <option value="1" <?= isset($_GET['sort']) && $_GET['sort'] == '1' ? 'selected' : '' ?>>High Price → High Price</option>
                                        <option value="2" <?= isset($_GET['sort']) && $_GET['sort'] == '2' ? 'selected' : '' ?>>Low Price → High Price</option>
                                        <option value="3" <?= isset($_GET['sort']) && $_GET['sort'] == '3' ? 'selected' : '' ?>>Best Selling</option>
                                    </select>
                                </div>
                                <p>Showing all <?= $productDisplayCount ?> results</p>
                            </div>
                            <div class="col-12 col-sm-4 text-center text-sm-right">
                                <ul class="nav nav-tabs ml-auto">
                                    <li>
                                        <a class="nav-link active" href="#grid-view" data-toggle="tab"> <i class="fa fa-th"></i> </a>
                                    </li>
                                    <li>
                                        <a class="nav-link" href="#list-view" data-toggle="tab"> <i class="fa fa-list-ul"></i> </a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="product-categorie-box">
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane fade show active" id="grid-view">
                                    <div class="row">
                                        <?php foreach ($dataProvider->models as $product): ?>
                                            <div class="col-sm-6 col-md-6 col-lg-4 col-xl-4">
                                                <div class="products-single fix">
                                                    <div class="box-img-hover">
                                                        <?php
                                                        $productImages = $product->imagems;
                                                        if (!empty($productImages)):
                                                            $firstImage = $productImages[0];
                                                        ?>
                                                            <img src="<?= yii\helpers\Url::to('../../backend/web/uploads/' . $firstImage->filename) ?>" class="img-fluid" alt=<?= $product->nome ?>>
                                                        <?php endif; ?>
                                                        <div class="mask-icon">
                                                            <ul>
                                                                <li><a href=<?= yii\helpers\Url::to(['produto/product-details', 'id' => $product->id]) ?> data-toggle="tooltip" data-placement="right" title="View"><i class="fas fa-eye"></i></a></li>
                                                                <?php if ($userWishlistIds != null && in_array($product->id, $userWishlistIds)): ?>
                                                                    <li><a href="<?= yii\helpers\Url::to(['favorito/delete', 'productId' => $product->id]) ?>" data-toggle="tooltip" data-placement="right" title="Remove from Wishlist"><i class="fas fa-heart"></i></a></li>
                                                                <?php else: ?>
                                                                    <li><a href="<?= yii\helpers\Url::to(['favorito/add-to-wishlist', 'productId' => $product->id]) ?>" data-toggle="tooltip" data-placement="right" title="Add to Wishlist"><i class="far fa-heart"></i></a></li>
                                                                <?php endif; ?>
                                                            </ul>
                                                            <a class="cart" href="<?= yii\helpers\Url::to(['carrinhoproduto/add-to-cart', 'productId' => $product->id, 'productQuantity' => 1]) ?>">Add to Cart</a>
                                                        </div>
                                                    </div>
                                                    <div class="why-text">
                                                        <h4><?= $product->nome ?></h4>
                                                        <h5><?= $product->preco ?>€</h5>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach ?>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="list-view">
                                    <div class="list-view-box">
                                        <div class="row">
                                            <?php foreach ($dataProvider->models as $product): ?>
                                                <div class="col-sm-6 col-md-6 col-lg-4 col-xl-4">
                                                    <div class="products-single fix">
                                                        <div class="box-img-hover">
                                                            <?php
                                                            $productImages = $product->imagems;
                                                            if (!empty($productImages)):
                                                                $firstImage = $productImages[0];
                                                            ?>
                                                                <img src="<?= yii\helpers\Url::to('../../backend/web/uploads/' . $firstImage->filename) ?>" class="img-fluid" alt=<?= $product->nome ?>>
                                                            <?php endif; ?>
                                                            <div class="mask-icon">
                                                                <ul>
                                                                    <li><a href=<?= yii\helpers\Url::to(['produto/product-details', 'id' => $product->id]) ?> data-toggle="tooltip" data-placement="right" title="View"><i class="fas fa-eye"></i></a></li>
                                                                    <?php if ($userWishlistIds != null && in_array($product->id, $userWishlistIds)): ?>
                                                                        <li><a href="<?= yii\helpers\Url::to(['favorito/delete', 'productId' => $product->id]) ?>" data-toggle="tooltip" data-placement="right" title="Remove from Wishlist"><i class="fas fa-heart"></i></a></li>
                                                                    <?php else: ?>
                                                                        <li><a href="<?= yii\helpers\Url::to(['favorito/add-to-wishlist', 'productId' => $product->id]) ?>" data-toggle="tooltip" data-placement="right" title="Add to Wishlist"><i class="far fa-heart"></i></a></li>
                                                                    <?php endif; ?>
                                                                </ul>
                                                                <a class="cart" href="<?= yii\helpers\Url::to(['carrinhoproduto/add-to-cart', 'productId' => $product->id, 'productQuantity' => 1]) ?>">Add to Cart</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-6 col-lg-8 col-xl-8">
                                                    <div class="why-text full-width">
                                                        <h4><?= $product->nome ?></h4>
                                                        <h5><?= $product->preco ?>€</h5>
                                                        <p><?= $product->descricao ?></p>
                                                        <a href="<?= yii\helpers\Url::to(['carrinhoproduto/add-to-cart', 'productId' => $product->id, 'productQuantity' => 1]) ?>" class="btn hvr-hover">Add to Cart</a>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
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
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-sm-12 col-xs-12 sidebar-shop-left">
                    <div class="product-categoria">
                        <div class="bg-black text-center py-2 mb-4 ">
                            <h2 class="text-white" style="font-size: 1.5rem;">Filters</h2>
                        </div>
                        <div class="filter-sidebar-left">
                            <div class="title-left">
                                <h3>Categories</h3>
                            </div>
                            <div class="list-group list-group-collapse list-group-sm list-group-tree" id="list-group-men" data-children=".sub-men">
                                <div class="list-group-collapse sub-men">
                                    <a class="list-group-item list-group-item-action <?= (Yii::$app->request->get('categoria_id') == null) ? 'active' : '' ?>" href="<?= yii\helpers\Url::to(['produto/index', 'categoria_id' => null]) ?>">All</a>
                                    <?php foreach ($categories as $category): ?>
                                        <a class="list-group-item list-group-item-action <?= ($category->id == Yii::$app->request->get('categoria_id')) ? 'active' : '' ?>"
                                            href="<?= yii\helpers\Url::to(['produto/index', 'categoria_id' => $category->id]) ?>">
                                            <?= $category->nome ?> <small class="text-muted">(<?= $productsPerCategory[$category->id] ?>)</small>
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                        <div class="filter-price-left">
                            <div class="title-left">
                                <h3>Price</h3>
                            </div>
                            <div class="price-box-slider">
                                <div id="slider-range"></div>
                                <p>
                                    <input type="text" id="amount" readonly style="border:0; color:#fbb714; font-weight:bold;">
                                    <button class="btn hvr-hover" type="button" id="filter-button">Filter</button>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Shop Page -->
</body>

</html>
<script>
    var minPrice = <?= isset($minPrice) ? json_encode($minPrice) : '0' ?>;
    var maxPrice = <?= isset($maxPrice) ? json_encode($maxPrice) : '1000' ?>;

    document.addEventListener("DOMContentLoaded", function() {
        var sortElement = document.getElementById("sort");
        if (sortElement !== null) {
            sortElement.addEventListener("change", function() {
                var sortValue = this.value;
                var url = new URL(window.location.href);

                url.searchParams.set('sort', sortValue);
                window.location.href = url.toString();
            });
        }
    });
</script>