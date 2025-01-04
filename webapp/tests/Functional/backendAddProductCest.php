<?php

namespace Tests\Functional;

use Tests\Support\FunctionalTester;

class BackendAddProductCest
{
    public function _before(FunctionalTester $I){}

    public function addProductWithValidData(FunctionalTester $I)
    {
        $I->amOnPage('gardenlabs/webapp/backend/views/site/login');
        $I->fillField('LoginForm[username]', 'admin'); 
        $I->fillField('LoginForm[password]', 'admin123');
        $I->click('Sign In');

        $I->see('Dashboard');
        
        $I->amOnPage('gardenlabs/webapp/backend/views/produto/index');
        $I->see('Produtos');
        $I->see('Create Produto', 'a.btn-success');

        $I->click('Create Produto');
        $I->see('Create Produto');

        $I->fillField('Produto[nome]', 'Test Product');
        $I->fillField('Produto[descricao]', 'This is a test product description.');
        $I->fillField('Produto[preco]', '100.00');
        $I->fillField('Produto[quantidade]', '10');
        $I->selectOption('Produto[categoria_id]', '1'); 
        $I->selectOption('Produto[fornecedor_id]', '1');
        $I->click('Save');

        $I->see('Produto has been created.');
        $I->see('Test Product');
        $I->see('100.00');
        $I->see('10');
    }

    public function addProductWithInvalidData(FunctionalTester $I)
    {
        $I->amOnPage('gardenlabs/webapp/backend/views/site/login');
        $I->fillField('LoginForm[username]', 'admin'); 
        $I->fillField('LoginForm[password]', 'admin123'); 
        $I->click('Sign In');

        $I->see('Dashboard');
        $I->amOnPage('gardenlabs/webapp/backend/views/produto/index');
        $I->see('Produtos');
        $I->see('Create Produto', 'a.btn-success');

        $I->click('Create Produto');
        $I->see('Create Produto');

        $I->fillField('Produto[nome]', ''); 
        $I->fillField('Produto[preco]', '-50'); 
        $I->fillField('Produto[quantidade]', '-10'); 
        $I->click('Save');

        $I->see('Nome cannot be blank.');
        $I->see('Preco must be no less than 0.01');
        $I->see('Quantidade must be no less than 0.');
    }
}
