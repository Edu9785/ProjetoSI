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
        $user = User::findByUsername($username);
        $profile = Profile::findOne(['id_user' => $user->id]);

        if (!$user || !$user->validatePassword($password)) {
            return [
                'status' => 'error',
                'message' => 'Credenciais inválidas.',
            ];
        }

        return [
            'status' => 'success',
            'token' => $user->auth_key,
            'id_profile' => $profile->id,
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


        $user = new User();
        $user->username = $username;
        $user->email = $email;
        $user->setPassword($password);
        $user->generateAuthKey();
        $user->save();


        $profile = new Profile();
        $profile->id_user = $user->id;
        $profile->nome = $nome;
        $profile->morada = $morada;
        $profile->telemovel = $telemovel;
        $profile->nif = $nif;
        $profile->save();

        $auth = Yii::$app->authManager;
        $role = $auth->getRole('utilizador');
        $auth->assign($role, $user->id);

        return [
            'status' => 'success',
            'message' => 'Utilizador criado com sucesso.',
            'user_id' => $user->id,
        ];
    }
}
