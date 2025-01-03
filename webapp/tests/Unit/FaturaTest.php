<?php

namespace Tests\Unit;

use Tests\Support\UnitTester;
use common\models\Fatura;
use common\models\Linhafatura;

class FaturaTest extends \Codeception\Test\Unit
{
    protected UnitTester $tester;

    protected function _before() {}

    public function testInvalidFatura()
    {
        $fatura = new Fatura();
        $fatura->total = null;
        $fatura->datahora = null;
        $fatura->nome_destinatario = '';
        $fatura->morada_destinatario = '';
        $fatura->preco_envio = null;
        $fatura->metodopagamento_id = null;
        $fatura->metodoexpedicao_id = null;
        $fatura->userprofile_id = null;

        $this->assertFalse($fatura->validate());
        $this->assertArrayHasKey('total', $fatura->errors);
        $this->assertArrayHasKey('datahora', $fatura->errors);
        $this->assertArrayHasKey('nome_destinatario', $fatura->errors);
        $this->assertArrayHasKey('morada_destinatario', $fatura->errors);
        $this->assertArrayHasKey('preco_envio', $fatura->errors);
        $this->assertArrayHasKey('metodopagamento_id', $fatura->errors);
        $this->assertArrayHasKey('metodoexpedicao_id', $fatura->errors);
        $this->assertArrayHasKey('userprofile_id', $fatura->errors);
    }

    public function testCreateValidFatura()
    {
        $fatura = new Fatura();
        $fatura->total = 500.75;
        $fatura->datahora = date('Y-m-d H:i:s');
        $fatura->nome_destinatario = 'John Doe';
        $fatura->morada_destinatario = '123 Main St';
        $fatura->telefone_destinatario = '123456789';
        $fatura->nif_destinatario = '987654321';
        $fatura->preco_envio = 10.50;
        $fatura->metodopagamento_id = 1;
        $fatura->metodoexpedicao_id = 1;
        $fatura->userprofile_id = 1;

        $this->assertTrue($fatura->save());

        $this->tester->seeInDatabase('fatura', ['nome_destinatario' => 'John Doe']);
    }

    public function testUpdateFatura()
    {
        $fatura = Fatura::findOne(['nome_destinatario' => 'John Doe']);

        $fatura->total = 600.00;
        $fatura->preco_envio = 12.00;

        $this->assertTrue($fatura->save());
        $this->tester->seeInDatabase('fatura', ['total' => 600.00, 'preco_envio' => 12.00]);
    }

    public function testDeleteFatura()
    {
        $fatura = Fatura::findOne(['nome_destinatario' => 'John Doe']);
        $this->assertTrue($fatura->delete());
        $this->tester->dontSeeInDatabase('fatura', ['nome_destinatario' => 'John Doe']);
    }

    public function testCalculateTotal()
    {
        $fatura = new Fatura();
        $fatura->datahora = date('Y-m-d H:i:s');
        $fatura->nome_destinatario = 'Jane Doe';
        $fatura->morada_destinatario = '456 Another St';
        $fatura->preco_envio = 5.00;
        $fatura->metodopagamento_id = 1;
        $fatura->metodoexpedicao_id = 1;
        $fatura->userprofile_id = 1;
        $fatura->save();

        $linha1 = new Linhafatura();
        $linha1->fatura_id = $fatura->id;
        $linha1->precounitario = 50.00;
        $linha1->quantidade = 2;
        $linha1->save();

        $linha2 = new Linhafatura();
        $linha2->fatura_id = $fatura->id;
        $linha2->precounitario = 25.00;
        $linha2->quantidade = 3;
        $linha2->save();

        $fatura->calculateTotal();

        $this->assertEquals(180.00, $fatura->total);
    }
}
