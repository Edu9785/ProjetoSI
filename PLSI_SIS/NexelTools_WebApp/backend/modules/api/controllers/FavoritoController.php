<?php

namespace backend\modules\api\controllers;

use yii\filters\auth\QueryParamAuth;
use yii\rest\ActiveController;
use frontend\models\Favorito;

class FavoritoController extends ActiveController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => QueryParamAuth::className(),
        ];
        return $behaviors;
    }

    public $modelClass = 'frontend\models\Favorito';

    public function actionUserfavoritos($id_profile){

        $favoritoclass = new $this->modelClass;

        $userfavoritos = $favoritoclass->find()->where(['id_user' => $id_profile])->all();

        return $userfavoritos;
    }
}