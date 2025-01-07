<?php


namespace Tests\Functional;

use Tests\Support\FunctionalTester;

class frontendAddToWishlistCest
{
    public function _before(FunctionalTester $I)
    {
    }

    public function addProductToWishlist(FunctionalTester $I)
    {
        $I->amOnPage('/frontend/web/site/login'); 
        $I->fillField(['id' => 'loginform-username'], 'diogo'); 
        $I->fillField(['id' => 'loginform-password'], 'diogo123');
        $I->click('Login');

        $I->amOnPage('/frontend/web/produto/index'); 
        $I->see('Product Shop'); 

        $I->click('.fa-heart');
        
        $I->amOnPage('/frontend/web/user/wishlist');
        $I->see('Wishlist'); 
        $I->see('Produto');
    }

    public function removeProductFromWishlist(FunctionalTester $I)
    {
        $I->amOnPage('/frontend/web/site/login'); 
        $I->fillField(['id' => 'loginform-username'], 'diogo'); 
        $I->fillField(['id' => 'loginform-password'], 'diogo123');
        $I->click('Login');

        $I->amOnPage('/frontend/web/user/wishlist'); 
        $I->see('Wishlist');

        $I->click('.fa-heart'); 
        $I->see('Your Wishlist is Empty!'); 
        $I->dontSee('Produto'); 
    }
}
