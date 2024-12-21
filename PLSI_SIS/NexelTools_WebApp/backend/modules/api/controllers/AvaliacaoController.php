<?php

namespace backend\modules\api\controllers;

use yii\filters\auth\QueryParamAuth;
use yii\rest\ActiveController;
use common\models\Avaliacao;

class AvaliacaoController extends ActiveController
{
    public $modelClass = 'common\models\Avaliacao';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => QueryParamAuth::className(),
            'except' => ['login'],
        ];
        return $behaviors;
    }
    public function actionAvaliacaoproduto($id_produto)
    {
        $avaliacaoclass = new $this->modelClass;

        $avaliacao = $avaliacaoclass->find()->where(['id_produto' => $id_produto])->all();

        return $avaliacao;
    }
}