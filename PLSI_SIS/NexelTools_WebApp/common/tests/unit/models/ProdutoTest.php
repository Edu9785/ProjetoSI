<?php


namespace common\tests\unit\models;

use common\models\Produto;
use common\tests\UnitTester;

class ProdutoTest extends \Codeception\Test\Unit
{

    protected UnitTester $tester;

    protected function _before()
    {
    }

    public function testValidarCamposObrigatorios()
    {
        $produto = new Produto();


        $this->assertFalse($produto->validate(), 'Validação falhou quando não foram preenchidos todos os campos obrigatórios');


        $produto->id_vendedor = 5;
        $produto->desc = "Descrição do produto";
        $produto->preco = 10;
        $produto->id_tipo = 26;
        $produto->nome = "Produto Exemplo";


        $this->assertTrue($produto->validate(), 'Validação falhou quando todos os campos obrigatórios foram preenchidos');
    }

    public function testRelacionamentoComCategorias()
    {
        $produto = Produto::findOne(11);
        $this->assertNotNull($produto->categoria);
        $this->assertEquals('Ferramentas de Jardinagem', $produto->categoria->tipo);

    }

    public function testRelacionamentoComProfile(){
        $produto = Produto::findOne(11);
        $this->assertNotNull($produto->profile->user->username);
        $this->assertEquals('God', $produto->profile->user->username);
    }

    public function testValidarPreco(){
        $produto = new Produto();
        $produto->preco = -1;
        $this->assertFalse($produto->validate(['preco']));
    }

    public function testValidarTiposDeValores()
    {
        $produto = new Produto();
        $produto->id_vendedor = "texto";
        $produto->desc = 1;
        $produto->preco = "preco";
        $produto->id_tipo = "categoria";
        $produto->nome = 23;


        $this->assertFalse($produto->validate());
    }

    public function testRelacionamentoComImagens()
    {
        $produto = Produto::findOne(11);
        $this->assertNotNull($produto->imagensprodutos);
        $this->assertGreaterThan(0, count($produto->imagensprodutos));
        $Imagem = $produto->imagensprodutos[0];
        $this->assertEquals('uploads/icwEgVMdx5C1YUcZ2bPUSkMok9OzXKe5.png', $Imagem->imagem->imagens);
    }
}
