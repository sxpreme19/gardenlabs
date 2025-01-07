<?php

namespace Tests\Unit;

use Tests\Support\UnitTester;
use common\models\Servico;

class ServicoTest extends \Codeception\Test\Unit
{

    protected UnitTester $tester;

    protected function _before() {}

    public function testServicoCrudOperations()
    {
        $servico = new Servico();
        $servico->descricao = 'Serviço de Teste';
        $servico->preco = 100.50;
        $servico->titulo = 'Test Service';
        $servico->duracao = 60;
        $servico->prestador_id = 1;

        $this->assertTrue($servico->save(), 'Valid Servico should be saved.');

        $this->tester->seeInDatabase('servico', [
            'descricao' => 'Serviço de Teste',
            'preco' => 100.50,
            'titulo' => 'Test Service',
            'duracao' => 60,
            'prestador_id' => 1
        ]);

        $servicoFromDb = Servico::findOne(['descricao' => 'Serviço de Teste']);
        $this->assertNotNull($servicoFromDb, 'Servico should be found in the database.');
        $this->assertEquals('Test Service', $servicoFromDb->titulo, 'Servico title should be "Test Service".');
        $this->assertEquals(100.50, $servicoFromDb->preco, 'Servico price should be 100.50.');

        $servicoFromDb->preco = 150.75;
        $servicoFromDb->titulo = 'Updated Test Service';
        $servicoFromDb->duracao = 90;

        $this->assertTrue($servicoFromDb->save(), 'Updated Servico should be saved.');

        $this->tester->seeInDatabase('servico', [
            'preco' => 150.75,
            'titulo' => 'Updated Test Service',
            'duracao' => 90
        ]);

        $this->assertEquals(1, $servicoFromDb->delete(), 'Servico should be deleted successfully.');
        $this->tester->dontSeeInDatabase('servico', ['descricao' => 'Serviço de Teste']);
    }
}
