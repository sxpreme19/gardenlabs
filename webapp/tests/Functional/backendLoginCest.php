<?php

namespace Tests\Functional;

use Tests\Support\FunctionalTester;

class BackendLoginCest
{
    public function _before(FunctionalTester $I){ }

    public function loginWithValidCredentials(FunctionalTester $I)
    {
        $I->amOnPage('/backend/web/site/login');

        $I->fillField(['id' => 'loginform-username'], 'tomas'); 
        $I->fillField(['id' => 'loginform-password'], 'tomas123');
        $I->click('Sign In');

        $I->see('Dashboard');
        $I->dontSee('Sign in to start your session');
    }

    public function loginWithInvalidCredentials(FunctionalTester $I)
    {
        $I->amOnPage('gardenlabs/webapp/backend/views/site/login');

        $I->fillField(['id' => 'loginform-username'], 'invalidUser');
        $I->fillField(['id' => 'loginform-password'], 'wrongPassword');
        $I->click('Sign In');

        $I->see('Invalid username or password.');
        $I->see('Sign in to start your session');
    }
}
