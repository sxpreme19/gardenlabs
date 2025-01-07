<?php

namespace Tests\Functional;

use Tests\Support\FunctionalTester;

class frontendEditAccountDetailsCest
{
    public function _before(FunctionalTester $I)
    {
    }

    public function editAccountDetails(FunctionalTester $I)
    {
        $I->amOnPage('/frontend/web/site/login'); 
        $I->fillField(['id' => 'loginform-username'], 'diogo'); 
        $I->fillField(['id' => 'loginform-password'], 'diogo123');
        $I->click('Login');

        $I->amOnPage('/frontend/web/user/account-details');
        $I->see('Edit Details'); 

        $newEmail = 'newemail@example.com';
        $newName = 'Updated Name';
        $newPhone = '912345678';
        $newNif = '123456789';

        $I->fillField(['id' => 'formupdateuser-email'], $newEmail);
        $I->fillField(['id' => 'formupdateuser-nome'], $newName);
        $I->fillField(['id' => 'formupdateuser-telefone'], $newPhone);
        $I->fillField(['id' => 'formupdateuser-nif'], $newNif);
        
        $I->click('Update'); 
        $I->see('Details have been updated successfully!');
    }
}
