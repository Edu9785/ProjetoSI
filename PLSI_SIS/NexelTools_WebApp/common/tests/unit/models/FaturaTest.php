<?php


namespace common\tests\unit\models;

use common\models\Compra;
use common\models\Fatura;
use common\models\Metodoexpedicao;
use common\models\Metodopagamento;
use common\models\Profile;
use common\models\User;
use common\tests\UnitTester;

class FaturaTest extends \Codeception\Test\Unit
{

    protected UnitTester $tester;
    protected $userId;
    protected $profileId;
    protected $compraId;
    protected $pagamentoId;
    protected $expedicaoId;

    protected $faturaId;



    protected function _before()
    {
        $this->userId = $this->tester->haveRecord(User::class, [
            'username' => 'tester',
            'auth_key' => 'authkey',
            'password_hash' => 'passwordhash',
            'email' => 'tester@example.com',
        ]);

        $this->profileId = $this->tester->haveRecord(Profile::class, [
            'id_user' => $this->userId,
            'nome' => 'tester',
            'telemovel' => 912345678,
            'nif' => 123456789,
            'morada' => 'rua 123',
            'avaliacao' => 0,
        ]);

        $this->pagamentoId = $this->tester->haveRecord(Metodopagamento::class, [
            'nomemetodo' => 'mbway',
        ]);

        $this->expedicaoId = $this->tester->haveRecord(Metodoexpedicao::class, [
            'nome' => 'DHL',
            'preco' => 15,
        ]);

        $this->compraId = $this->tester->haveRecord(Compra::class, [
            'id_profile' => $this->profileId,
            'datacompra' => date('y-m-d-m-Y-H-i-s'),
            'precototal' => 912,
            'id_metodopagamento' => $this->pagamentoId,
            'id_metodoexpedicao' => $this->expedicaoId,
        ]);

        $this->faturaId = $this->tester->haveRecord(Fatura::class, [
            'precofatura' => 500,
            'datahora' => date('y-m-d-m-Y-H-i-s'),
            'id_profile' => $this->profileId,
            'id_compra' => $this->compraId,
        ]);

    }

    public function testValidarCamposObrigatorios()
    {
        $fatura = new Fatura();
        $this->assertFalse($fatura->validate());

        $fatura->precofatura = 30;
        $fatura->datahora = date('Y-m-d H:i:s');
        $fatura->id_profile = $this->profileId;
        $fatura->id_compra = $this->compraId;
        $this->assertTrue($fatura->validate());
    }

    public function testValidarTiposDeEntrada()
    {
        $fatura = new Fatura();

        $fatura->precofatura = 'preco';
        $fatura->datahora = 12;
        $fatura->id_profile = 'comprador';
        $fatura->id_compra = 'compra';
        $this->assertFalse($fatura->validate());
    }

    public function testRelacionamentoComProfile()
    {
        $fatura = Fatura::findOne($this->faturaId);
        $this->assertNotNull($fatura->id_profile);
        $this->assertEquals($this->profileId ,$fatura->id_profile);
    }

    public function testRelacionamentoComCompra()
    {
        $fatura = Fatura::findOne($this->faturaId);
        $this->assertNotNull($fatura->id_compra);
        $this->assertEquals($this->compraId ,$fatura->id_compra);
    }

    public function testCreateFatura()
    {
        $fatura = new Fatura();
        $fatura->id_profile = $this->profileId;
        $fatura->datahora = date('Y-m-d H:i:s');
        $fatura->precofatura = 90;
        $fatura->id_compra = $this->compraId;

        $this->assertTrue($fatura->save(), 'Fatura guardada');

        $fatura = Fatura::findOne($fatura->id);
        $this->assertNotNull($fatura, 'fatura não encontrada.');
        $this->assertEquals(90, $fatura->precofatura, 'preco fatura incorreta.');
    }

}
