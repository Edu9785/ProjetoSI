<?php


namespace common\tests\unit\models;

use common\models\Compra;
use common\models\Fatura;
use common\models\Metodoexpedicao;
use common\models\Metodopagamento;
use common\models\Profile;
use common\models\User;
use common\tests\UnitTester;

class CompraTest extends \Codeception\Test\Unit
{

    protected UnitTester $tester;
    protected $userId;
    protected $profileId;
    protected $compraId;
    protected $pagamentoId;
    protected $expedicaoId;

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
    }

    public function testValidarCamposObrigatorios()
    {
        $compra = new Compra();
        $this->assertFalse($compra->validate());

        $compra->id_profile = $this->profileId;
        $compra->datacompra = date('Y-m-d H:i:s');
        $compra->precototal = 32;
        $compra->id_metodopagamento = $this->pagamentoId;
        $compra->id_metodoexpedicao = $this->expedicaoId;
        $this->assertTrue($compra->validate());
    }

    public function testValidarTiposDeEntrada()
    {
        $compra = new Compra();
        $compra->id_profile = 'profile';
        $compra->datacompra = 12;
        $compra->precototal = 'preco';
        $compra->id_metodopagamento = 'pagamento';
        $compra->id_metodoexpedicao = 'expedicao';
        $this->assertFalse($compra->validate());
    }

    public function testRelacionamentoComProfile()
    {
        $compra = Compra::findOne($this->compraId);
        $this->assertNotNull($compra->id_profile);
        $this->assertEquals($this->profileId , $compra->id_profile);
    }

    public function testRelacionamentoComMetodoPagamento()
    {
        $compra = Compra::findOne($this->compraId);
        $this->assertNotNull($compra->id_metodopagamento);
        $this->assertEquals($this->pagamentoId ,$compra->id_metodopagamento);
    }

    public function testRelacionamentoComMetodoExpedicao()
    {
        $compra = Compra::findOne($this->compraId);
        $this->assertNotNull($compra->id_metodoexpedicao);
        $this->assertEquals($this->expedicaoId ,$compra->id_metodoexpedicao);
    }

    public function testCreateFatura()
    {
        $compra = new Compra();
        $compra->id_profile = $this->profileId;
        $compra->datacompra = date('Y-m-d H:i:s');
        $compra->precototal = 32;
        $compra->id_metodopagamento = $this->pagamentoId;
        $compra->id_metodoexpedicao = $this->expedicaoId;
        $this->assertTrue($compra->save(), 'Compra guardada');

        $compra = Compra::findOne($compra->id);
        $this->assertNotNull($compra, 'compra não encontrada.');
        $this->assertEquals(32, $compra->precototal, 'preco incorret.');
    }
}
