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

        //Backend permissions
        $accessBackend = $auth->createPermission('accessBackend');
        $accessBackend->description = 'Access backend';
        $auth->add($accessBackend);

        $createUser = $auth->createPermission('createUser');
        $createUser->description = 'Create user';
        $auth->add($createUser);

        $updateUser = $auth->createPermission('updateUser');
        $updateUser->description = 'Update user';
        $auth->add($updateUser);

        $deleteUser = $auth->createPermission('deleteUser');
        $deleteUser->description = 'Delete user';
        $auth->add($deleteUser);

        $createProduct = $auth->createPermission('createProduct');
        $createProduct->description = 'Create product';
        $auth->add($createProduct);

        $editProduct = $auth->createPermission('editProduct');
        $editProduct->description = 'Edit product';
        $auth->add($editProduct);

        $deleteProduct = $auth->createPermission('deleteProduct');
        $deleteProduct->description = 'Delete product';
        $auth->add($deleteProduct);

        $manageProductImages = $auth->createPermission('manageProductImages');
        $manageProductImages->description = 'Manage product images';
        $auth->add($manageProductImages);

        $createService = $auth->createPermission('createService');
        $createService->description = 'Create service';
        $auth->add($createService);

        $editService = $auth->createPermission('editService');
        $editService->description = 'Edit service';
        $auth->add($editService);

        $deleteService = $auth->createPermission('deleteService');
        $deleteService->description = 'Delete service';
        $auth->add($deleteService);
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
