<?php

namespace Tests\Unit;

use Tests\Support\UnitTester;
use common\models\User;

class UserTest extends \Codeception\Test\Unit
{
    protected UnitTester $tester;

    protected function _before(){}

    public function testUserCrudOperations()
    {
        $user = new User();
        
        $user->email = 'invalid_email';
        $this->assertFalse($user->validate(), 'User should not be valid with an invalid email.');
        $user->email = 'user@example.com';
        $user->username = '';
        $this->assertFalse($user->validate(), 'User should not be valid with an empty username.');

        $user = new User();
        $user->username = 'validuser';
        $user->email = 'validuser@example.com';
        $user->status = User::STATUS_ACTIVE; 
        $user->setPassword('password123');
        $user->generateAuthKey();
        
        $this->assertTrue($user->save(), 'Valid user should be saved to the database.');

        $foundUser = User::findOne(['username' => 'validuser']);
        $this->assertNotNull($foundUser, 'User should be found in the database.');
        $this->assertEquals('validuser', $foundUser->username, 'User username should match.');
        
        $foundUser->email = 'newemail@example.com';
        
        $this->assertTrue($foundUser->save(), 'User should be updated successfully.');
        
        $updatedUser = User::findOne(['username' => 'validuser']);
        $this->assertNotNull($updatedUser, 'Updated user should still be found in the database.');
        $this->assertEquals('newemail@example.com', $updatedUser->email, 'User email should be updated.');
        
        $this->assertEquals(1, $updatedUser->delete(), 'User should be deleted successfully.');
        
        $deletedUser = User::findOne(['username' => 'validuser']);
        $this->assertNull($deletedUser, 'User should no longer exist in the database after deletion.');
    }
}

