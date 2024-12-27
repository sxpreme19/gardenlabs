<?php

use yii\db\Migration;

/**
 * Class m241116_220638_init_rbac
 */
class m241116_220638_init_rbac extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $auth = Yii::$app->authManager;

        #region - roles 
        $admin = $auth->createRole('admin');
        $manager = $auth->createRole('manager');
        $client = $auth->createRole('client');

        //Provider (Mobile Role)
        $provider = $auth->createRole('provider');

        $auth->add($admin);
        $auth->add($manager);
        $auth->add($client);
        $auth->add($provider);
        #endregion

        #region - permissions

            #region - Frontend permissions

        $addToCart = $auth->createPermission('addToCart');
        $addToCart->description = 'Add to cart';
        $auth->add($addToCart);

        $updateQuantity = $auth->createPermission('updateQuantity');
        $updateQuantity->description = 'Update quantity';
        $auth->add($updateQuantity);

        $removeFromCart = $auth->createPermission('removeFromCart');
        $removeFromCart->description = 'Remove from cart';
        $auth->add($removeFromCart);

        $addToWishlist = $auth->createPermission('addToWishlist');
        $addToWishlist->description = 'Add to wishlist';
        $auth->add($addToWishlist);

        $removeFromWishlist = $auth->createPermission('removeFromWishlist');
        $removeFromWishlist->description = 'Remove from wishlist';
        $auth->add($removeFromWishlist);

        $cartCheckout = $auth->createPermission('cartCheckout');
        $cartCheckout->description = 'Cart checkout';
        $auth->add($cartCheckout);

        $confirmCheckout = $auth->createPermission('confirmCheckout');
        $confirmCheckout->description = 'Confirm checkout';
        $auth->add($confirmCheckout);

        $orderConfirmed = $auth->createPermission('orderConfirmed');
        $orderConfirmed->description = 'Order confirmed';
        $auth->add($orderConfirmed);

        $ordersHistory = $auth->createPermission('ordersHistory');
        $ordersHistory->description = 'Orders history';
        $auth->add($ordersHistory);

        $orderDetails = $auth->createPermission('orderDetails');
        $orderDetails->description = 'Order details';
        $auth->add($orderDetails);

        $accountDetails = $auth->createPermission('accountDetails');
        $accountDetails->description = 'Account details';
        $auth->add($accountDetails);

        $editAccountDetails = $auth->createPermission('editAccountDetails');
        $editAccountDetails->description = 'Edit account details';
        $auth->add($editAccountDetails);

        $deleteAccount = $auth->createPermission('deleteAccount');
        $deleteAccount->description = 'Delete account';
        $auth->add($deleteAccount);

        $leaveReview = $auth->createPermission('leaveReview');
        $leaveReview->description = 'Leave review';
        $auth->add($leaveReview);

        $deleteOwnReview = $auth->createPermission('deleteOwnReview');
        $deleteOwnReview->description = 'Delete own review';
        $auth->add($deleteOwnReview);

        #endregion

            #region - Backend permissions
            $accessBackend = $auth->createPermission('accessBackend');
            $accessBackend->description = 'Access backend';
            $auth->add($accessBackend);

            #region - User Control

        $usersIndex = $auth->createPermission('usersIndex');
        $usersIndex->description = 'Users Index';
        $auth->add($usersIndex);

        $createUser = $auth->createPermission('createUser');
        $createUser->description = 'Create user';
        $auth->add($createUser);

        $viewUser = $auth->createPermission('viewUser');
        $viewUser->description = 'View user';
        $auth->add($viewUser);

        $updateUser = $auth->createPermission('updateUser');
        $updateUser->description = 'Update user';
        $auth->add($updateUser);

        $deleteUser = $auth->createPermission('deleteUser');
        $deleteUser->description = 'Delete user';
        $auth->add($deleteUser);

        $userProfilesIndex = $auth->createPermission('usersProfilesIndex');
        $userProfilesIndex->description = 'User Profiles Index';
        $auth->add($userProfilesIndex);

        $createUserProfile = $auth->createPermission('createUserProfile');
        $createUserProfile->description = 'Create user profile';
        $auth->add($createUserProfile);

        $viewUserProfile = $auth->createPermission('viewUserProfile');
        $viewUserProfile->description = 'View user profile';
        $auth->add($viewUserProfile);

        $updateUserProfile = $auth->createPermission('updateUserProfile');
        $updateUserProfile->description = 'Update user profile';
        $auth->add($updateUserProfile);

        $deleteUserProfile = $auth->createPermission('deleteUserProfile');
        $deleteUserProfile->description = 'Delete user profile';
        $auth->add($deleteUserProfile);
        #endregion

            #region - Shopping Management

        $productsIndex = $auth->createPermission('productsIndex');
        $productsIndex->description = 'Products Index';
        $auth->add($productsIndex);

        $createProduct = $auth->createPermission('createProduct');
        $createProduct->description = 'Create product';
        $auth->add($createProduct);

        $viewProduct = $auth->createPermission('viewProduct');
        $viewProduct->description = 'View product';
        $auth->add($viewProduct);

        $editProduct = $auth->createPermission('editProduct');
        $editProduct->description = 'Edit product';
        $auth->add($editProduct);

        $deleteProduct = $auth->createPermission('deleteProduct');
        $deleteProduct->description = 'Delete product';
        $auth->add($deleteProduct);

        $manageProductImages = $auth->createPermission('manageProductImages');
        $manageProductImages->description = 'Manage product images';
        $auth->add($manageProductImages);

        $servicesIndex = $auth->createPermission('servicesIndex');
        $servicesIndex->description = 'Services Index';
        $auth->add($servicesIndex);

        $createService = $auth->createPermission('createService');
        $createService->description = 'Create service';
        $auth->add($createService);

        $viewService = $auth->createPermission('viewService');
        $viewService->description = 'View service';
        $auth->add($viewService);

        $editService = $auth->createPermission('editService');
        $editService->description = 'Edit service';
        $auth->add($editService);

        $deleteService = $auth->createPermission('deleteService');
        $deleteService->description = 'Delete service';
        $auth->add($deleteService);

        $wishlistsIndex = $auth->createPermission('wishlistsIndex');
        $wishlistsIndex->description = 'Wishlists Index';
        $auth->add($wishlistsIndex);

        $createWishlist = $auth->createPermission('createWishlist');
        $createWishlist->description = 'Create wishlist';
        $auth->add($createWishlist);

        $viewWishlist = $auth->createPermission('viewWishlist');
        $viewWishlist->description = 'View wishlist';
        $auth->add($viewWishlist);

        $editWishlist = $auth->createPermission('editWishlist');
        $editWishlist->description = 'Edit wishlist';
        $auth->add($editWishlist);

        $deleteWishlist = $auth->createPermission('deleteWishlist');
        $deleteWishlist->description = 'Delete wishlist';
        $auth->add($deleteWishlist);

        $reviewsIndex = $auth->createPermission('reviewsIndex');
        $reviewsIndex->description = 'Reviews Index';
        $auth->add($reviewsIndex);

        $createReview = $auth->createPermission('createReview');
        $createReview->description = 'Create review';
        $auth->add($createReview);

        $viewReview = $auth->createPermission('viewReview');
        $viewReview->description = 'View review';
        $auth->add($viewReview);

        $editReview = $auth->createPermission('editReview');
        $editReview->description = 'Edit review';
        $auth->add($editReview);

        $deleteReview = $auth->createPermission('deleteReview');
        $deleteReview->description = 'Delete review';
        $auth->add($deleteReview);

        $categoriesIndex = $auth->createPermission('categoriesIndex');
        $categoriesIndex->description = 'Categories Index';
        $auth->add($categoriesIndex);

        $createCategory = $auth->createPermission('createCategory');
        $createCategory->description = 'Create category';
        $auth->add($createCategory);

        $viewCategory = $auth->createPermission('viewCategory');
        $viewCategory->description = 'View category';
        $auth->add($viewCategory);

        $editCategory = $auth->createPermission('editCategory');
        $editCategory->description = 'Edit category';
        $auth->add($editCategory);

        $deleteCategory = $auth->createPermission('deleteCategory');
        $deleteCategory->description = 'Delete category';
        $auth->add($deleteCategory);

        $suppliersIndex = $auth->createPermission('suppliersIndex');
        $suppliersIndex->description = 'Suppliers Index';
        $auth->add($suppliersIndex);

        $createSupplier = $auth->createPermission('createSupplier');
        $createSupplier->description = 'Create supplier';
        $auth->add($createSupplier);

        $viewSupplier = $auth->createPermission('viewSupplier');
        $viewSupplier->description = 'View supplier';
        $auth->add($viewSupplier);

        $editSupplier = $auth->createPermission('editSupplier');
        $editSupplier->description = 'Edit supplier';
        $auth->add($editSupplier);

        $deleteSupplier = $auth->createPermission('deleteSupplier');
        $deleteSupplier->description = 'Delete supplier';
        $auth->add($deleteSupplier);

        $imagesIndex = $auth->createPermission('imagesIndex');
        $imagesIndex->description = 'Images Index';
        $auth->add($imagesIndex);

        $uploadImages = $auth->createPermission('uploadImages');
        $uploadImages->description = 'Upload images';
        $auth->add($uploadImages);

        $viewImage = $auth->createPermission('viewImage');
        $viewImage->description = 'View image';
        $auth->add($viewImage);

        $deleteImage = $auth->createPermission('deleteImage');
        $deleteImage->description = 'Delete image';
        $auth->add($deleteImage);
        #endregion

            #region - Cart Management

        $productCartsIndex = $auth->createPermission('productCartsIndex');
        $productCartsIndex->description = 'Product Carts Index';
        $auth->add($productCartsIndex);

        $productCartCreate = $auth->createPermission('productCartCreate');
        $productCartCreate->description = 'Create product cart';
        $auth->add($productCartCreate);

        $productCartUpdate = $auth->createPermission('productCartUpdate');
        $productCartUpdate->description = 'Update product cart';
        $auth->add($productCartUpdate);

        $productCartDelete = $auth->createPermission('productCartDelete');
        $productCartDelete->description = 'Delete product cart';
        $auth->add($productCartDelete);

        $productCartView = $auth->createPermission('productCartView');
        $productCartView->description = 'View product cart';
        $auth->add($productCartView);

        $serviceCartsIndex = $auth->createPermission('serviceCartsIndex');
        $serviceCartsIndex->description = 'Service Carts Index';
        $auth->add($serviceCartsIndex);

        $serviceCartCreate = $auth->createPermission('serviceCartCreate');
        $serviceCartCreate->description = 'Create service cart';
        $auth->add($serviceCartCreate);

        $serviceCartUpdate = $auth->createPermission('serviceCartUpdate');
        $serviceCartUpdate->description = 'Update service cart';
        $auth->add($serviceCartUpdate);

        $serviceCartDelete = $auth->createPermission('serviceCartDelete');
        $serviceCartDelete->description = 'Delete service cart';
        $auth->add($serviceCartDelete);

        $serviceCartView = $auth->createPermission('serviceCartView');
        $serviceCartView->description = 'View service cart';
        $auth->add($serviceCartView);

        $productCartLinesIndex = $auth->createPermission('productCartLinesIndex');
        $productCartLinesIndex->description = 'Product Cart Lines Index';
        $auth->add($productCartLinesIndex);

        $productCartLineCreate = $auth->createPermission('productCartLineCreate');
        $productCartLineCreate->description = 'Create product cart line';
        $auth->add($productCartLineCreate);

        $productCartLineUpdate = $auth->createPermission('productCartLineUpdate');
        $productCartLineUpdate->description = 'Update product cart line';
        $auth->add($productCartLineUpdate);

        $productCartLineDelete = $auth->createPermission('productCartLineDelete');
        $productCartLineDelete->description = 'Delete product cart line';
        $auth->add($productCartLineDelete);

        $productCartLineView = $auth->createPermission('productCartLineView');
        $productCartLineView->description = 'View product cart line';
        $auth->add($productCartLineView);

        $serviceCartLinesIndex = $auth->createPermission('serviceCartLinesIndex');
        $serviceCartLinesIndex->description = 'Service Cart Lines Index';
        $auth->add($serviceCartLinesIndex);

        $serviceCartLineCreate = $auth->createPermission('serviceCartLineCreate');
        $serviceCartLineCreate->description = 'Create service cart line';
        $auth->add($serviceCartLineCreate);

        $serviceCartLineUpdate = $auth->createPermission('serviceCartLineUpdate');
        $serviceCartLineUpdate->description = 'Update service cart line';
        $auth->add($serviceCartLineUpdate);

        $serviceCartLineDelete = $auth->createPermission('serviceCartLineDelete');
        $serviceCartLineDelete->description = 'Delete service cart line';
        $auth->add($serviceCartLineDelete);

        $serviceCartLineView = $auth->createPermission('serviceCartLineView');
        $serviceCartLineView->description = 'View service cart line';
        $auth->add($serviceCartLineView);

        #endregion

            #region - Order Management

        $invoicesIndex = $auth->createPermission('invoicesIndex');
        $invoicesIndex->description = 'Invoices Index';
        $auth->add($invoicesIndex);

        $invoiceCreate = $auth->createPermission('invoiceCreate');
        $invoiceCreate->description = 'Create invoice';
        $auth->add($invoiceCreate);

        $invoiceUpdate = $auth->createPermission('invoiceUpdate');
        $invoiceUpdate->description = 'Update invoice';
        $auth->add($invoiceUpdate);

        $invoiceDelete = $auth->createPermission('invoiceDelete');
        $invoiceDelete->description = 'Delete invoice';
        $auth->add($invoiceDelete);

        $invoiceView = $auth->createPermission('invoiceView');
        $invoiceView->description = 'View invoice';
        $auth->add($invoiceView);

        $invoiceLinesIndex = $auth->createPermission('invoiceLinesIndex');
        $invoiceLinesIndex->description = 'Invoice Lines Index';
        $auth->add($invoiceLinesIndex);

        $invoiceLineCreate = $auth->createPermission('invoiceLineCreate');
        $invoiceLineCreate->description = 'Create invoice line';
        $auth->add($invoiceLineCreate);

        $invoiceLineUpdate = $auth->createPermission('invoiceLineUpdate');
        $invoiceLineUpdate->description = 'Update invoice line';
        $auth->add($invoiceLineUpdate);

        $invoiceLineDelete = $auth->createPermission('invoiceLineDelete');
        $invoiceLineDelete->description = 'Delete invoice line';
        $auth->add($invoiceLineDelete);

        $invoiceLineView = $auth->createPermission('invoiceLineView');
        $invoiceLineView->description = 'View invoice line';
        $auth->add($invoiceLineView);

        $expeditionMethodsIndex = $auth->createPermission('expeditionMethodsIndex');
        $expeditionMethodsIndex->description = 'Expedition Methods Index';
        $auth->add($expeditionMethodsIndex);

        $expeditionMethodCreate = $auth->createPermission('expeditionMethodCreate');
        $expeditionMethodCreate->description = 'Create expedition method';
        $auth->add($expeditionMethodCreate);

        $expeditionMethodUpdate = $auth->createPermission('expeditionMethodUpdate');
        $expeditionMethodUpdate->description = 'Update expedition method';
        $auth->add($expeditionMethodUpdate);

        $expeditionMethodDelete = $auth->createPermission('expeditionMethodDelete');
        $expeditionMethodDelete->description = 'Delete expedition method';
        $auth->add($expeditionMethodDelete);

        $expeditionMethodView = $auth->createPermission('expeditionMethodView');
        $expeditionMethodView->description = 'View expedition method';
        $auth->add($expeditionMethodView);

        $paymentMethodsIndex = $auth->createPermission('paymentMethodsIndex');
        $paymentMethodsIndex->description = 'Payment Methods Index';
        $auth->add($paymentMethodsIndex);

        $paymentMethodCreate = $auth->createPermission('paymentMethodCreate');
        $paymentMethodCreate->description = 'Create payment method';
        $auth->add($paymentMethodCreate);

        $paymentMethodUpdate = $auth->createPermission('paymentMethodUpdate');
        $paymentMethodUpdate->description = 'Update payment method';
        $auth->add($paymentMethodUpdate);

        $paymentMethodDelete = $auth->createPermission('paymentMethodDelete');
        $paymentMethodDelete->description = 'Delete payment method';
        $auth->add($paymentMethodDelete);

        $paymentMethodView = $auth->createPermission('paymentMethodView');
        $paymentMethodView->description = 'View payment method';
        $auth->add($paymentMethodView);

        #endregion
        
        #endregion

        #endregion

        #region - assign permissions

            #region - Client permissions

            $auth->addChild($client, $addToCart);
            $auth->addChild($client, $removeFromCart);
            $auth->addChild($client, $updateQuantity);
            $auth->addChild($client, $addToWishlist);
            $auth->addChild($client, $removeFromWishlist);
            $auth->addChild($client, $cartCheckout);
            $auth->addChild($client, $confirmCheckout);
            $auth->addChild($client, $orderConfirmed);
            $auth->addChild($client, $ordersHistory);
            $auth->addChild($client, $orderDetails);
            $auth->addChild($client, $accountDetails);
            $auth->addChild($client, $editAccountDetails);
            $auth->addChild($client, $deleteAccount);
            $auth->addChild($client, $leaveReview);
            $auth->addChild($client, $deleteOwnReview);

        #endregion

            #region - Manager permissions
        $auth->addChild($manager, $accessBackend);

        $auth->addChild($manager, $productsIndex);
        $auth->addChild($manager, $createProduct);
        $auth->addChild($manager, $editProduct);
        $auth->addChild($manager, $viewProduct);
        $auth->addChild($manager, $manageProductImages);

        $auth->addChild($manager, $servicesIndex);
        $auth->addChild($manager, $createService);
        $auth->addChild($manager, $editService);
        $auth->addChild($manager, $viewService);

        $auth->addChild($manager, $wishlistsIndex);
        $auth->addChild($manager, $createWishlist);
        $auth->addChild($manager, $editWishlist);
        $auth->addChild($manager, $viewWishlist);

        $auth->addChild($manager, $reviewsIndex);
        $auth->addChild($manager, $createReview);
        $auth->addChild($manager, $editReview);
        $auth->addChild($manager, $viewReview);

        $auth->addChild($manager, $categoriesIndex);
        $auth->addChild($manager, $createCategory);
        $auth->addChild($manager, $editCategory);
        $auth->addChild($manager, $viewCategory);

        $auth->addChild($manager, $suppliersIndex);
        $auth->addChild($manager, $createSupplier);
        $auth->addChild($manager, $editSupplier);
        $auth->addChild($manager, $viewSupplier);

        $auth->addChild($manager, $imagesIndex);
        $auth->addChild($manager, $uploadImages);
        $auth->addChild($manager, $viewImage);

        $auth->addChild($manager, $productCartsIndex);
        $auth->addChild($manager, $productCartCreate);
        $auth->addChild($manager, $productCartUpdate);
        $auth->addChild($manager, $productCartView);

        $auth->addChild($manager, $productCartLinesIndex);
        $auth->addChild($manager, $productCartLineCreate);
        $auth->addChild($manager, $productCartLineUpdate);
        $auth->addChild($manager, $productCartLineView);

        $auth->addChild($manager, $serviceCartsIndex);
        $auth->addChild($manager, $serviceCartCreate);
        $auth->addChild($manager, $serviceCartUpdate);
        $auth->addChild($manager, $serviceCartView);

        $auth->addChild($manager, $serviceCartLinesIndex);
        $auth->addChild($manager, $serviceCartLineCreate);
        $auth->addChild($manager, $serviceCartLineUpdate);
        $auth->addChild($manager, $serviceCartLineView);
        #endregion

            #region - Admin permissions
        $auth->addChild($admin, $manager);

        $auth->addChild($admin, $usersIndex);
        $auth->addChild($admin, $createUser);
        $auth->addChild($admin, $updateUser);
        $auth->addChild($admin, $deleteUser);
        $auth->addChild($admin, $viewUser);
        $auth->addChild($admin, $userProfilesIndex);
        $auth->addChild($admin, $createUserProfile);
        $auth->addChild($admin, $updateUserProfile);
        $auth->addChild($admin, $deleteUserProfile);
        $auth->addChild($admin, $viewUserProfile);

        $auth->addChild($admin, $deleteProduct);
        $auth->addChild($admin, $deleteService);
        $auth->addChild($admin, $deleteWishlist);
        $auth->addChild($admin, $deleteReview);
        $auth->addChild($admin, $deleteCategory);
        $auth->addChild($admin, $deleteSupplier);
        $auth->addChild($admin, $deleteImage);
        $auth->addChild($admin, $productCartDelete);
        $auth->addChild($admin, $productCartLineDelete);
        $auth->addChild($admin, $serviceCartDelete);
        $auth->addChild($admin, $serviceCartLineDelete);

        $auth->addChild($admin, $invoicesIndex);
        $auth->addChild($admin, $invoiceCreate);
        $auth->addChild($admin, $invoiceUpdate);
        $auth->addChild($admin, $invoiceDelete);
        $auth->addChild($admin, $invoiceView);

        $auth->addChild($admin, $invoiceLinesIndex);
        $auth->addChild($admin, $invoiceLineCreate);
        $auth->addChild($admin, $invoiceLineUpdate);
        $auth->addChild($admin, $invoiceLineDelete);
        $auth->addChild($admin, $invoiceLineView);

        $auth->addChild($admin, $expeditionMethodsIndex);
        $auth->addChild($admin, $expeditionMethodCreate);
        $auth->addChild($admin, $expeditionMethodUpdate);
        $auth->addChild($admin, $expeditionMethodDelete);
        $auth->addChild($admin, $expeditionMethodView);

        $auth->addChild($admin, $paymentMethodsIndex);
        $auth->addChild($admin, $paymentMethodCreate);
        $auth->addChild($admin, $paymentMethodUpdate);
        $auth->addChild($admin, $paymentMethodDelete);
        $auth->addChild($admin, $paymentMethodView);
        #endregion

        #endregion

        echo "m241116_220638_init_rbac applied.\n";
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $auth = Yii::$app->authManager;
        $auth->removeAll();

        echo "m241116_220638_init_rbac cannot be reverted.\n";

        return false;
    }

    /*
    public function up()
    {
        $auth = Yii::$app->authManager;

        //roles 
        $admin = $auth->createRole('admin');
        $manager = $auth->createRole('manager');
        $client = $auth->createRole('client');

        $auth->add($admin);
        $auth->add($manager);
        $auth->add($client);
        
    }

    public function down()
    {
        echo "m241116_220638_init_rbac cannot be reverted.\n";

        return false;
    }*/
}
