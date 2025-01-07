<?php

namespace Tests\Unit;

use Tests\Support\UnitTester;
use common\models\Fornecedor;

class FornecedorTest extends \Codeception\Test\Unit
{

    protected UnitTester $tester;

    protected function _before() {}

    public function testFornecedorCrudOperations()
    {
        $fornecedor = new Fornecedor();

        $fornecedor->email = 'invalidemail@example.com';
        $fornecedor->telefone = 123456789;
        $fornecedor->localizacao = 'Sample Location';
        $this->assertFalse($fornecedor->validate(['nome']), 'Fornecedor should not be valid with missing nome.');

        $fornecedor->nome = 'Fornecedor A';
        $fornecedor->telefone = 'invalid_phone'; 
        $this->assertFalse($fornecedor->validate(['telefone']), 'Fornecedor should not be valid with invalid telefone.');

        $fornecedor = new Fornecedor();
        $fornecedor->nome = 'Fornecedor A';
        $fornecedor->email = 'fornecedorA@example.com';
        $fornecedor->telefone = 987654321;
        $fornecedor->localizacao = 'New York, USA';

        $this->assertTrue($fornecedor->save(), 'Valid fornecedor should be saved to the database.');

        $foundFornecedor = Fornecedor::findOne(['nome' => 'Fornecedor A']);
        $this->assertNotNull($foundFornecedor, 'Fornecedor should be found in the database.');
        $this->assertEquals('Fornecedor A', $foundFornecedor->nome, 'Fornecedor nome should match.');
        $this->assertEquals('fornecedorA@example.com', $foundFornecedor->email, 'Fornecedor email should match.');

        $foundFornecedor->telefone = 123123123; 
        $foundFornecedor->localizacao = 'Los Angeles, USA'; 

        $this->assertTrue($foundFornecedor->save(), 'Fornecedor should be updated successfully.');

        $updatedFornecedor = Fornecedor::findOne(['nome' => 'Fornecedor A']);
        $this->assertNotNull($updatedFornecedor, 'Updated fornecedor should still be found in the database.');
        $this->assertEquals(123123123, $updatedFornecedor->telefone, 'Fornecedor telefone should be updated.');
        $this->assertEquals('Los Angeles, USA', $updatedFornecedor->localizacao, 'Fornecedor localizacao should be updated.');

        $this->assertEquals(1, $updatedFornecedor->delete(), 'Fornecedor should be deleted successfully.');

        $deletedFornecedor = Fornecedor::findOne(['nome' => 'Fornecedor A']);
        $this->assertNull($deletedFornecedor, 'Fornecedor should no longer exist in the database after deletion.');
    }
}
