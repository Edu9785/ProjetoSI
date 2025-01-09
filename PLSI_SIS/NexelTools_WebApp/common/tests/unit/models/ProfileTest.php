<?php


namespace common\tests\unit\models;

use common\models\Profile;
use common\models\User;
use common\tests\UnitTester;
use yii\db\IntegrityException;

class ProfileTest extends \Codeception\Test\Unit
{

    protected UnitTester $tester;
    protected $profileId;
    protected $userId;

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
    }

    public function testValidarCamposObrigatorios()
    {
        $profile = new Profile();
        $this->assertFalse($profile->validate());

        $profile->nif = 123456789;
        $profile->morada = "Rua, 123";
        $profile->nome = "João";
        $profile->id_user = $this->userId;
        $profile->telemovel = 912345678;
        $this->assertTrue($profile->validate());
    }

    public function testValidarTiposDeEntrada()
    {
        $profile = new Profile();
        $profile->nif = 'nif';
        $profile->morada = 10;
        $profile->nome = 12;
        $profile->id_user = 'user';
        $profile->telemovel = 'telemovel';
        $this->assertFalse($profile->validate());
    }

    public function testRelacionamentoComUser()
    {
        $profile = Profile::findOne($this->profileId);
        $this->assertNotNull($profile);
        $this->assertNotNull($profile->user);
        $this->assertEquals($profile->user->id, $profile->id_user);
    }

    public function testCreateProfile()
    {
        $profile = new Profile();
        $profile->id_user = $this->userId;
        $profile->nif = 987654321;
        $profile->morada = "Rua, 456";
        $profile->nome = "Eduardo";
        $profile->telemovel = 987654321;
        $this->assertTrue($profile->save(), 'Erro ao criar perfil.');

        $Profile = Profile::findOne($profile->id);
        $this->assertNotNull($Profile, 'Perfil não encontrado.');
        $this->assertEquals($Profile->nome, 'Eduardo', 'Nome incorreto.');
    }

    public function testReadProfile()
    {
        $profile = Profile::findOne($this->profileId);
        $this->assertNotNull($profile, 'Perfil não encontrado.');
        $this->assertEquals($profile->nome, 'tester', 'Nome incorreto.');
    }

    public function testUpdateProfile()
    {
        $profile = Profile::findOne($this->profileId);
        $profile->nome = 'Novo Nome';

        $this->assertTrue($profile->save(), 'Perfil não atualizado.');

        $profile = Profile::findOne($this->profileId);
        $this->assertEquals($profile->nome, 'Novo Nome', 'Nome do perfil não foi atualizado.');
    }

    public function testDeleteProduto()
    {
        $profile = Profile::findOne($this->profileId);
        $this->assertNotNull($profile, 'Profile não encontrado.');
        $profile->delete();
        $profileDeletado = Profile::findOne($this->profileId);
        $this->assertNull($profileDeletado, 'Profile não deletado.');
    }
}
