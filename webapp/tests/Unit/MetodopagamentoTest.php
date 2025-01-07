<?php

namespace Tests\Unit;

use Tests\Support\UnitTester;
use common\models\Metodopagamento;

class MetodopagamentoTest extends \Codeception\Test\Unit
{

    protected UnitTester $tester;

    protected function _before() {}

    public function testMetodopagamentoCrudOperations()
    {
        $metodopagamento = new Metodopagamento();

        $metodopagamento->disponivel = 1;
        $this->assertFalse($metodopagamento->validate(['descricao']), 'Metodopagamento should not be valid with missing descricao.');

        $metodopagamento->descricao = str_repeat('a', 46);
        $this->assertFalse($metodopagamento->validate(['descricao']), 'Metodopagamento should not be valid with descricao length > 45.');

        $metodopagamento = new Metodopagamento();
        $metodopagamento->descricao = 'Credit Card';
        $metodopagamento->disponivel = 1;

        $this->assertTrue($metodopagamento->save(), 'Valid metodopagamento should be saved to the database.');

        $foundMetodopagamento = Metodopagamento::findOne(['descricao' => 'Credit Card']);
        $this->assertNotNull($foundMetodopagamento, 'Metodopagamento should be found in the database.');
        $this->assertEquals('Credit Card', $foundMetodopagamento->descricao, 'Metodopagamento descricao should match.');
        $this->assertEquals(1, $foundMetodopagamento->disponivel, 'Metodopagamento disponivel should be true.');

        $foundMetodopagamento->descricao = 'Debit Card';
        $foundMetodopagamento->disponivel = 0;

        $this->assertTrue($foundMetodopagamento->save(), 'Metodopagamento should be updated successfully.');

        $updatedMetodopagamento = Metodopagamento::findOne(['descricao' => 'Debit Card']);
        $this->assertNotNull($updatedMetodopagamento, 'Updated metodopagamento should still be found in the database.');
        $this->assertEquals(0, $updatedMetodopagamento->disponivel, 'Metodopagamento disponivel should be false.');

        $this->assertEquals(1, $updatedMetodopagamento->delete(), 'Metodopagamento should be deleted successfully.');

        $deletedMetodopagamento = Metodopagamento::findOne(['descricao' => 'Debit Card']);
        $this->assertNull($deletedMetodopagamento, 'Metodopagamento should no longer exist in the database after deletion.');
    }
}
