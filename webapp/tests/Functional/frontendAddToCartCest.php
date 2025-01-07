<?php


namespace Tests\Functional;

use Tests\Support\FunctionalTester;

class frontendAddToCartCest
{
    public function _before(FunctionalTester $I)
    {
    }

    public function addProductToCart(FunctionalTester $I)
    {
        $I->amOnPage('/frontend/web/site/login'); 
        $I->fillField(['id' => 'loginform-username'], 'diogo');
        $I->fillField(['id' => 'loginform-password'], 'diogo123'); 
        $I->click('Login');

        $I->amOnPage('/frontend/web/produto/index'); 
        $I->see('Product Shop');

        $I->click(['link' => 'Add to Cart']);
        $I->amOnPage('/frontend/web/carrinhoproduto/index'); 
        $I->see('Cart');
        $I->see('Produto'); 
    }

    public function removeProductFromCart(FunctionalTester $I)
    {
        $I->amOnPage('/frontend/web/site/login'); 
        $I->fillField(['id' => 'loginform-username'], 'diogo');
        $I->fillField(['id' => 'loginform-password'], 'diogo123'); 
        $I->click('Login');

        $I->amOnPage('/frontend/web/carrinhoproduto/index'); 
        $I->see('Cart');

        $I->click(['link' => 'Remove']);
        $I->see('Your Cart is Empty!'); 
        $I->dontSee('Produto'); 
    }
}
