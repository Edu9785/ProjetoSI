<?php

namespace backend\modules\api\controllers;

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

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => QueryParamAuth::className(),
            'except' => ['login'],
            ];
        return $behaviors;
    }
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLogin()
    {
        $request = Yii::$app->request->post();

        $username = $request['username'] ?? null;
        $password = $request['password'] ?? null;

        if (!$username || !$password) {
            return [
                'status' => 'error',
                'message' => 'Username e senha são obrigatórios.',
            ];
        }

        $user = User::findOne(['username' => $username]);

        if (!$user || !Yii::$app->getSecurity()->validatePassword($password, $user->password_hash)) {
            return [
                'status' => 'error',
                'message' => 'Credenciais inválidas.',
            ];
        }

        return [
            'status' => 'success',
            'token' => $user->auth_key,
            'user_id' => $user->id,
        ];
    }

}
