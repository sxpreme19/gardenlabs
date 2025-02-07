<?php

namespace Tests\Functional;

use Tests\Support\FunctionalTester;

class BackendAddProductCest
{
    public function _before(FunctionalTester $I){}

    public function addProductWithValidData(FunctionalTester $I)
    {
        $I->amOnPage('/backend/web/index.php?r=site%2Flogin');
        codecept_debug($I->grabFromCurrentUrl());
        $I->fillField('#loginform-username', 'tomas'); 
        $I->fillField('#loginform-password', 'tomas123');
        $I->click('Sign In');
        
        $I->amOnPage('/backend/web/index.php?r=produto%2Findex');
        $I->see('Produtos');
        $I->see('Create Produto', 'a.btn-success');

        $I->click('Create Produto');
        $I->see('Create Produto');

        $I->fillField(['id' => 'productform-nome'], 'Test Product');
        $I->fillField(['id' => 'productform-descricao'], 'This is a test product description.');
        $I->fillField(['id' => 'productform-preco'], '100.00');
        $I->fillField(['id' => 'productform-quantidade'], '10');
        $I->selectOption(['id' => 'productform-categoria_id'], '1'); 
        $I->selectOption(['id' => 'productform-fornecedor_id'], '1');
        $I->click('Save');

        $I->see('Produto has been created.');
        $I->see('Test Product');
        $I->see('100.00');
        $I->see('10');
    }

    public function addProductWithInvalidData(FunctionalTester $I)
    {
        $I->amOnPage('/backend/web/index.php?r=site%2Flogin');
        $I->fillField(['id' => 'loginform-username'], 'tomas'); 
        $I->fillField(['id' => 'loginform-password'], 'tomas123');
        $I->click('Sign In');

        $I->amOnPage('/backend/web/index.php?r=produto%2Findex');
        $I->see('Produtos');
        $I->see('Create Produto', 'a.btn-success');

        $I->click('Create Produto');
        $I->see('Create Produto');

        $I->fillField(['id' => 'productform-nome'], ''); 
        $I->fillField(['id' => 'productform-preco'], '-50'); 
        $I->fillField(['id' => 'productform-quantidade'], '-10'); 
        $I->click('Save');

        $I->see('Nome cannot be blank.');
        $I->see('Preco must be no less than 0.01');
        $I->see('Quantidade must be no less than 0.');
    }
}
