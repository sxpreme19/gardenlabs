<?php

namespace Tests\Unit;

use Tests\Support\UnitTester;
use common\models\Metodoexpedicao;

class MetodoexpedicaoTest extends \Codeception\Test\Unit
{

    protected UnitTester $tester;

    protected function _before() {}

    public function testMetodoexpedicaoCrudOperations()
    {
        $metodoexpedicao = new Metodoexpedicao();

        $metodoexpedicao->preco = 100.50;
        $metodoexpedicao->duracao = '3-5 days';
        $metodoexpedicao->disponivel = 1;
        $this->assertFalse($metodoexpedicao->validate(['descricao']), 'Metodoexpedicao should not be valid with missing descricao.');

        $metodoexpedicao = new Metodoexpedicao();
        $metodoexpedicao->descricao = 'Express Shipping';
        $metodoexpedicao->preco = 50.75;
        $metodoexpedicao->duracao = '1-2 days';
        $metodoexpedicao->disponivel = 1;

        $this->assertTrue($metodoexpedicao->save(), 'Valid metodoexpedicao should be saved to the database.');

        $foundMetodoexpedicao = Metodoexpedicao::findOne(['descricao' => 'Express Shipping']);
        $this->assertNotNull($foundMetodoexpedicao, 'Metodoexpedicao should be found in the database.');
        $this->assertEquals('Express Shipping', $foundMetodoexpedicao->descricao, 'Metodoexpedicao descricao should match.');
        $this->assertEquals(50.75, $foundMetodoexpedicao->preco, 'Metodoexpedicao preco should match.');
        $this->assertEquals('1-2 days', $foundMetodoexpedicao->duracao, 'Metodoexpedicao duracao should match.');

        $foundMetodoexpedicao->descricao = 'Overnight Shipping';
        $foundMetodoexpedicao->preco = 75.25;
        $foundMetodoexpedicao->duracao = 'Next day';
        $foundMetodoexpedicao->disponivel = 0;

        $this->assertTrue($foundMetodoexpedicao->save(), 'Metodoexpedicao should be updated successfully.');

        $updatedMetodoexpedicao = Metodoexpedicao::findOne(['descricao' => 'Overnight Shipping']);
        $this->assertNotNull($updatedMetodoexpedicao, 'Updated metodoexpedicao should still be found in the database.');
        $this->assertEquals(75.25, $updatedMetodoexpedicao->preco, 'Metodoexpedicao preco should be updated.');
        $this->assertEquals('Next day', $updatedMetodoexpedicao->duracao, 'Metodoexpedicao duracao should be updated.');
        $this->assertEquals(0, $updatedMetodoexpedicao->disponivel, 'Metodoexpedicao disponivel should be false.');

        $this->assertEquals(1, $updatedMetodoexpedicao->delete(), 'Metodoexpedicao should be deleted successfully.');

        $deletedMetodoexpedicao = Metodoexpedicao::findOne(['descricao' => 'Overnight Shipping']);
        $this->assertNull($deletedMetodoexpedicao, 'Metodoexpedicao should no longer exist in the database after deletion.');
    }
}
