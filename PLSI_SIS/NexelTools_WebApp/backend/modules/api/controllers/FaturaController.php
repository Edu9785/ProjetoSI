<?php

namespace backend\modules\api\controllers;

use yii\filters\auth\QueryParamAuth;
use yii\rest\ActiveController;
use common\models\Fatura;

class FaturaController extends ActiveController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => QueryParamAuth::className(),
        ];
        return $behaviors;
    }
    public $modelClass = 'common\models\Fatura';

    public function actionUserfaturas($id_profile){

        $faturasclass = new $this->modelClass;
        $userFaturas = $faturasclass->find()->where(['id_profile' => $id_profile])->all();

        return $userFaturas;
    }
}