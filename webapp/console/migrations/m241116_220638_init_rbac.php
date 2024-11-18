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

        //roles 
        $admin = $auth->createRole('admin');
        $manager = $auth->createRole('manager');
        $client = $auth->createRole('client');

        $auth->add($admin);
        $auth->add($manager);
        $auth->add($client);

        //permissions
        $accessBackend = $auth->createPermission('accessBackend');
        $accessBackend->description = 'Access backend';
        $auth->add($accessBackend);

        //assign permissions
        $auth->addChild($admin, $accessBackend);
        $auth->addChild($manager, $accessBackend);
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
