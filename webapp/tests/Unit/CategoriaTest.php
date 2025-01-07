<?php

namespace Tests\Unit;

use Tests\Support\UnitTester;
use common\models\Categoria;

class CategoriaTest extends \Codeception\Test\Unit
{
    protected UnitTester $tester;

    protected function _before() {}

    public function testCategoriaCrudOperations()
    {
        $categoria = new Categoria();
        $categoria->nome = '';
        $this->assertFalse($categoria->validate(['nome']), 'Categoria should not be valid with an empty nome.');


        $categoria->nome = str_repeat('a', 81);
        $this->assertFalse($categoria->validate(['nome']), 'Categoria should not be valid with nome longer than 80 characters.');

        $categoria = new Categoria();
        $categoria->nome = 'Categoria A'; 
        $this->assertTrue($categoria->save(), 'Valid categoria should be saved to the database.');

        $foundCategoria = Categoria::findOne(['nome' => 'Categoria A']);
        $this->assertNotNull($foundCategoria, 'Categoria should be found in the database.');
        $this->assertEquals('Categoria A', $foundCategoria->nome, 'Categoria nome should match.');

        $foundCategoria->nome = 'Categoria B';
        $this->assertTrue($foundCategoria->save(), 'Categoria should be updated successfully.');

        $updatedCategoria = Categoria::findOne(['nome' => 'Categoria B']);
        $this->assertNotNull($updatedCategoria, 'Updated categoria should still be found in the database.');
        $this->assertEquals('Categoria B', $updatedCategoria->nome, 'Categoria nome should be updated.');

        $this->assertEquals(1, $updatedCategoria->delete(), 'Categoria should be deleted successfully.');
        $deletedCategoria = Categoria::findOne(['nome' => 'Categoria B']);
        $this->assertNull($deletedCategoria, 'Categoria should no longer exist in the database after deletion.');
    }
}
