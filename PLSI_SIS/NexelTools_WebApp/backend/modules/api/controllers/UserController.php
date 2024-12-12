<?php

namespace backend\modules\api\controllers;

use common\models\Profile;
use Yii;
use yii\rest\ActiveController;
use yii\web\Controller;
use yii\filters\auth\QueryParamAuth;
use common\models\User;
use yii\web\Response;

/**
 * Default controller for the `api` module
 */
class UserController extends ActiveController
{
   public $modelClass = 'common\models\User';
    /**
     * Renders the index view for the module
     * @return string
     */

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLogin()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $request = Yii::$app->request->post();

        $username = $request['username'] ?? null;
        $password = $request['password'] ?? null;

        if (!$username || !$password) {
            return [
                'status' => 'error',
                'message' => 'Username e senha são obrigatórios.',
            ];
        }

        $user = User::findByUsername($username);

        if (!$user || !$user->validatePassword($password)) {
            return [
                'status' => 'error',
                'message' => 'Credenciais inválidas.',
            ];
        }

        return [
            'status' => 'success',
            'token' => $user->auth_key,
        ];
    }

    public function actionRegistar()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $request = Yii::$app->request->post();

        $username = $request['username'] ?? null;
        $email = $request['email'] ?? null;
        $password = $request['password'] ?? null;
        $nome = $request['nome'] ?? null;
        $morada = $request['morada'] ?? null;
        $telemovel = $request['telemovel'] ?? null;
        $nif = $request['nif'] ?? null;

        if (!$username || !$email || !$password || !$nome || !$morada || !$telemovel || !$nif) {
            return [
                'status' => 'error',
                'message' => 'Todos os campos são obrigatórios.',
            ];
        }

        $user = new User();
        $user->username = $username;
        $user->email = $email;
        $user->setPassword($password);
        $user->generateAuthKey();

        if (!$user->save()) {
            throw new \Exception('Erro ao guardar utilizador: ' . json_encode($user->errors));
        }

        $profile = new Profile();
        $profile->id_user = $user->id;
        $profile->nome = $nome;
        $profile->morada = $morada;
        $profile->telemovel = $telemovel;
        $profile->nif = $nif;

        if (!$profile->save()) {
            throw new \Exception('Erro ao guardar perfil: ' . json_encode($profile->errors));
        }

        $auth = Yii::$app->authManager;
        $role = $auth->getRole('utilizador');

        if (!$role) {
            throw new \Exception('Role "utilizador" não encontrada.');
        }

        $auth->assign($role, $user->id);

        return [
            'status' => 'success',
            'message' => 'Utilizador criado com sucesso.',
            'user_id' => $user->id,
        ];
    }
}
