<?php

namespace Tests\Functional;

use Tests\Support\FunctionalTester;

class frontendSignupCest
{
    public function _before(FunctionalTester $I)
    {
    }

    public function signUpWithValidCredentials(FunctionalTester $I)
    {
        $I->amOnPage('/frontend/views/site/signup');

        $I->fillField(['id' => 'formsignup-username'], 'tomas'); 
        $I->fillField(['id' => 'formsignup-email'], 'tomas'); 
        $I->fillField(['id' => 'formsignup-password'], 'tomas123');
        $I->click('Signup');

        $I->see('Please fill out the following fields to signup:');
        $I->dontSee('Please fill out the following fields to login:');
    }

    public function signUpWithInvalidCredentials(FunctionalTester $I)
    {
        $I->amOnPage('/frontend/views/site/signup');

        $I->fillField(['id' => 'formsignup-username'], 'invalidUser');
        $I->fillField(['id' => 'formsignup-email'], 'invalidEmail'); 
        $I->fillField(['id' => 'formsignup-password'], 'wrongPassword');
        $I->click('Signup');

        $I->see('Invalid username, email or password.');
        $I->see('Please fill out the following fields to signup:');
    }
}
