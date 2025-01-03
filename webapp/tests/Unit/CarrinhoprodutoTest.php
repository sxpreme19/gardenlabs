<?php

namespace Tests\Unit;

use Tests\Support\UnitTester;
use common\models\Carrinhoproduto;
use common\models\Linhacarrinhoproduto;

class CarrinhoprodutoTest extends \Codeception\Test\Unit
{
    protected UnitTester $tester;

    protected function _before() {}

    public function testInvalidCarrinhoproduto()
    {
        $carrinhoproduto = new Carrinhoproduto();

        $carrinhoproduto->userprofile_id = null;

        $this->assertFalse($carrinhoproduto->validate());
        $this->assertArrayHasKey('userprofile_id', $carrinhoproduto->errors);
    }

    public function testCreateValidCarrinhoproduto()
    {
        $carrinhoproduto = new Carrinhoproduto();
        $carrinhoproduto->userprofile_id = 1;

        $this->assertTrue($carrinhoproduto->save());
        $this->tester->seeInDatabase('carrinhoproduto', ['userprofile_id' => 1]);
    }

    public function testUpdateCarrinhoproduto()
    {
        $carrinhoproduto = Carrinhoproduto::findOne(['userprofile_id' => 1]);
        $carrinhoproduto->total = 150.50;
        $this->assertTrue($carrinhoproduto->save());
        $this->tester->seeInDatabase('carrinhoproduto', ['total' => 150.50]);
    }

    public function testDeleteCarrinhoproduto()
    {

        $carrinhoproduto = Carrinhoproduto::findOne(['userprofile_id' => 1]);
        $this->assertTrue($carrinhoproduto->delete());
        $this->tester->dontSeeInDatabase('carrinhoproduto', ['userprofile_id' => 1]);
    }

    public function testCalculateTotal()
    {
        $carrinhoproduto = new Carrinhoproduto();
        $carrinhoproduto->userprofile_id = 2;
        $carrinhoproduto->save();

        $linha1 = new Linhacarrinhoproduto();
        $linha1->carrinhoproduto_id = $carrinhoproduto->id;
        $linha1->precounitario = 50.00;
        $linha1->quantidade = 2; 
        $linha1->save();

        $linha2 = new Linhacarrinhoproduto();
        $linha2->carrinhoproduto_id = $carrinhoproduto->id;
        $linha2->precounitario = 30.00;
        $linha2->quantidade = 3; 
        $linha2->save();

        $calculatedTotal = $carrinhoproduto->calculateTotal();

        $this->assertEquals(190.00, $calculatedTotal);
        $this->assertEquals(190.00, $carrinhoproduto->total);
    }
}
