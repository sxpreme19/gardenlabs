<?php

namespace Tests\Unit;

use Tests\Support\UnitTester;
use common\models\Produto;

class ProdutoTest extends \Codeception\Test\Unit
{

    protected UnitTester $tester;

    protected function _before() {}

    public function testProdutoCrudOperations()
    {
        $produto = new Produto();

        $produto->descricao = str_repeat('a', 201);
        $this->assertFalse($produto->validate(['descricao']), 'Product should not be valid with description length > 200.');

        $produto->preco = 'invalid_price';
        $this->assertFalse($produto->validate(['preco']), 'Product should not be valid with an invalid price.');

        $produto = new Produto();
        $produto->descricao = 'A valid product description';
        $produto->preco = 99.99;
        $produto->nome = 'Product A';
        $produto->quantidade = 10;
        $produto->fornecedor_id = 1;
        $produto->categoria_id = 2;

        $this->assertTrue($produto->save(), 'Valid product should be saved to the database.');

        $foundProduto = Produto::findOne(['nome' => 'Product A']);
        $this->assertNotNull($foundProduto, 'Product should be found in the database.');
        $this->assertEquals('Product A', $foundProduto->nome, 'Product name should match.');

        $foundProduto->preco = 79.99; 
        $foundProduto->quantidade = 20; 

        $this->assertTrue($foundProduto->save(), 'Product should be updated successfully.');

        $updatedProduto = Produto::findOne(['nome' => 'Product A']);
        $this->assertNotNull($updatedProduto, 'Updated product should still be found in the database.');
        $this->assertEquals(79.99, $updatedProduto->preco, 'Product price should be updated.');
        $this->assertEquals(20, $updatedProduto->quantidade, 'Product quantity should be updated.');

        $this->assertTrue($updatedProduto->delete(), 'Product should be deleted successfully.');

        $deletedProduto = Produto::findOne(['nome' => 'Product A']);
        $this->assertNull($deletedProduto, 'Product should no longer exist in the database after deletion.');
    }
}
