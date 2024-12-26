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

        //Manager permissions
        $auth->addChild($manager, $accessBackend);
        $auth->addChild($manager, $createProduct);
        $auth->addChild($manager, $editProduct);
        $auth->addChild($manager, $deleteProduct);
        $auth->addChild($manager, $manageProductImages);
        $auth->addChild($manager, $createService);
        $auth->addChild($manager, $editService);

        //Admin permissions
        $auth->addChild($admin, $manager);
        $auth->addChild($admin, $createUser);
        $auth->addChild($admin, $updateUser);
        $auth->addChild($admin, $deleteUser);
        $auth->addChild($admin,$deleteProduct);
        $auth->addChild($manager, $deleteService);
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
