<?php


namespace common\tests\unit\models;

use common\models\Avaliacao;
use common\models\Categoria;
use common\models\Produto;
use common\models\Profile;
use common\models\User;
use common\tests\UnitTester;

class AvaliacaoTest extends \Codeception\Test\Unit
{

    protected UnitTester $tester;
    protected $produtoId;
    protected $profileId;
    protected $categoriaId;
    protected $userId;
    protected $avaliacaoId;

    protected function _before()
    {
        $this->categoriaId = $this->tester->haveRecord(Categoria::class, [
            'id' => 1,
            'tipo' => 'Ferramentas manuais'
        ]);

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

        $this->produtoId = $this->tester->haveRecord(Produto::class, [
            'id_vendedor' => $this->profileId,
            'desc' => 'Descrição do produto',
            'preco' => 10,
            'id_tipo' => $this->categoriaId,
            'nome' => 'Produto',
        ]);

        $this->avaliacaoId = $this->tester->haveRecord(Avaliacao::class,[
           'id_user' => $this->profileId,
            'desc' => 'produto excelente',
            'avaliacao' => 5,
            'id_produto' => $this->produtoId,
        ]);

    }

    public function testValidarCamposObrigatorios()
    {
        $avaliacao = new Avaliacao();

        $this->assertFalse($avaliacao->validate());

        $avaliacao->id_user = $this->profileId;
        $avaliacao->desc = 'Produto excelente';
        $avaliacao->avaliacao = 5;
        $avaliacao->id_produto = $this->produtoId;

        $this->assertTrue($avaliacao->validate());
    }

    public function testValidarTiposDeEntrada()
    {
        $avaliacao = new Avaliacao();
        $avaliacao->id_user = 'profile';
        $avaliacao->desc = 5;
        $avaliacao->avaliacao = 'avaliacao';
        $avaliacao->id_produto = 'produto';

        $this->assertFalse($avaliacao->validate());
    }

    public function testRelacionamentoComProfile()
    {
        $avaliacao = Avaliacao::findOne($this->avaliacaoId);
        $this->assertNotNull($avaliacao->id_user);
        $this->assertEquals($this->profileId, $avaliacao->id_user);
    }

    public function testRelacionamentoComProduto(){
        $avaliacao = Avaliacao::findOne(2);
        $this->assertNotNull($avaliacao->id_produto);
        $this->assertEquals(9, $avaliacao->id_produto);
    }

    public function testCreateAvaliacao()
    {
        $avaliacao = new Avaliacao();
        $avaliacao->id_user = $this->profileId;
        $avaliacao->desc = 'Produto muito bom';
        $avaliacao->avaliacao = 4;
        $avaliacao->id_produto = $this->produtoId;

        $this->assertTrue($avaliacao->save(), 'Avaliacao guardada');

        $avaliacao = Avaliacao::findOne($avaliacao->id);
        $this->assertNotNull($avaliacao, 'Avaliacao não encontrada.');
        $this->assertEquals('Produto muito bom', $avaliacao->desc, 'Descrição da avaliação incorreta.');
    }

    public function testReadAvaliacao()
    {
        $avaliacao = Avaliacao::findOne($this->avaliacaoId);
        $this->assertNotNull($avaliacao, 'Avaliacao não encontrada.');
        $this->assertEquals('produto excelente', $avaliacao->desc, 'Descrição da avaliação incorreta.');
    }

    public function testUpdateAvaliacao()
    {
        $avaliacao = Avaliacao::findOne($this->avaliacaoId);
        $avaliacao->desc = 'Avaliação atualizada';
        $this->assertTrue($avaliacao->save(), 'Avaliacao não atualizada.');
        $this->assertEquals('Avaliação atualizada', $avaliacao->desc, 'Descrição da avaliação não foi atualizada.');
    }

    public function testDeleteAvaliacao()
    {
        $avaliacao = Avaliacao::findOne($this->avaliacaoId);
        $this->assertNotNull($avaliacao, 'Avaliacao não encontrado.');
        $avaliacao->delete();
        $avaliacaoDeletada = Avaliacao::findOne($this->avaliacaoId);
        $this->assertNull($avaliacaoDeletada, 'Avaliacao não deletada.');
    }
}
