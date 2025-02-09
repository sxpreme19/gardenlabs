<?php

namespace Tests\Functional;

use Tests\Support\FunctionalTester;

class BackendLoginCest
{
    public function _before(FunctionalTester $I){ }

    public function loginWithValidCredentials(FunctionalTester $I)
    {
        $I->amOnPage('/backend/web/index.php?r=site%2Flogin');

        $I->fillField('#loginform-username', 'tomas');
        $I->fillField('#loginform-password', 'tomas123');
        $I->click('Sign In');

        $I->see('Dashboard');
        $I->dontSee('Sign in to start your session');
    }

    public function loginWithInvalidCredentials(FunctionalTester $I)
    {
        $I->amOnPage('/backend/web/index.php?r=site%2Flogin');

        $I->fillField('#loginform-username', 'invalidUser');
        $I->fillField('#loginform-password', 'wrongPassword');
        $I->click('Sign In');

        $I->see('Invalid username or password.');
        $I->see('Sign in to start your session');
    }
}
