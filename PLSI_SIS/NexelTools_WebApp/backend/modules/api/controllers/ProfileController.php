<?php

namespace backend\modules\api\controllers;

use Yii;
use yii\filters\auth\QueryParamAuth;
use yii\rest\ActiveController;
use common\models\Profile;

class ProfileController extends ActiveController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => QueryParamAuth::className(),

        ];
        return $behaviors;
    }

    public $modelClass = 'common\models\Profile';

    public function actionUserprofile(){

        $profileclass = new $this->modelClass;

        $id_user = \Yii::$app->user->id;
        $profile = $profileclass->findOne(['id_user' => $id_user]);

        return[
            'id' => $profile->id,
            'username' => $profile->user->username,
            'email' => $profile->user->email,
            'nome' => $profile->nome,
            'morada' => $profile->morada,
            'nif' => $profile->nif,
            'telemovel' => $profile->telemovel,
            'avaliacao' => $profile->avaliacao,
        ];
    }



    public function actionEditaruserprofile(){

        $profileclass = new $this->modelClass;

        $id_user= \Yii::$app->user->id;
        $profile = $profileclass->findOne(['id_user' => $id_user]);

        $data = Yii::$app->request->post();

        $profile->user->username = $data['username'];
        $profile->user->email = $data['email'];
        $profile->nome = $data['nome'];
        $profile->morada = $data['morada'];
        $profile->nif = $data['nif'];
        $profile->telemovel = $data['telemovel'];
        $profile->save();

        return['message' => 'Perfil Atualizado com sucesso'];
    }
}