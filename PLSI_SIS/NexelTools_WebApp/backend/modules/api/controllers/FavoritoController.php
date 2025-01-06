<?php

namespace backend\modules\api\controllers;

use common\models\Profile;
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

    public function actionAddfavorito($id_produto){

        $id_user = \Yii::$app->user->id;
        $profile = Profile::findOne(['id_user' => $id_user]);
        $favorito = new Favorito();
        $favorito->id_user = $profile->id;
        $favorito->id_produto = $id_produto;
        $favorito->save();
        return $favorito;
    }

    public function actionRemoverfavorito($id_produto){

        $favoritoclass = new $this->modelClass();
        $id_user = \Yii::$app->user->id;
        $profile = Profile::findOne(['id_user' => $id_user]);

        $remover = $favoritoclass->find()->where(['id_produto' => $id_produto])->andWhere(['id_user' => $profile->id])->one();

        $remover->delete();

        return $remover;
    }
}