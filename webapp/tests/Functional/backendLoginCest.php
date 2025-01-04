<?php

namespace Tests\Functional;

use Tests\Support\FunctionalTester;

class BackendLoginCest
{
    public function _before(FunctionalTester $I){ }

    public function loginWithValidCredentials(FunctionalTester $I)
    {
        $I->amOnPage('gardenlabs/webapp/backend/views/site/login');

        $I->fillField('input[name="LoginForm[username]"]', 'tomas'); 
        $I->fillField('input[name="LoginForm[password]"]', 'tomas123');
        $I->click('Sign In');

        $I->see('Dashboard');
        $I->dontSee('Sign in to start your session');
    }

    public function loginWithInvalidCredentials(FunctionalTester $I)
    {
        $I->amOnPage('gardenlabs/webapp/backend/views/site/login');

        $I->fillField('input[name="LoginForm[username]"]', 'invalidUser');
        $I->fillField('input[name="LoginForm[password]"]', 'wrongPassword');
        $I->click('Sign In');

        $I->see('Invalid username or password.');
        $I->see('Sign in to start your session');
    }
}
