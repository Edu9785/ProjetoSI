<?php

namespace backend\modules\api\controllers;

use common\models\Linhafatura;
use common\models\Produto;
use common\models\Profile;
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

    public function actionGetcomprafatura($id_compra){

        $faturaclass = new $this->modelClass;

        $fatura = $faturaclass->findOne(['id_compra' => $id_compra]);

        $linhas = Linhafatura::find()->where(['id_fatura' => $fatura->id])->all();

        $linhasFatura = [];

        foreach ($linhas as $linha) {
            $produto = Produto::findOne($linha->id_produto);
            $produtolinha = [
                'id_produto' => $produto->id,
                'nome' => $produto->nome,
                'preco' => $produto->preco,
                'vendedor' => $produto->profile->user->username,
            ];

            $linhasFatura[] = $produtolinha;
        }

        return [
            'id' => $fatura->id,
            'linhasfatura' => $linhasFatura,
            'precofatura' => $fatura->precofatura,
            'metodoexpedicaopreco' => $fatura->compra->metodoexpedicao->preco,
            'metodoexpedicaonome' => $fatura->compra->metodoexpedicao->nome,
            'datahora' => $fatura->datahora,
            'comprador' => $fatura->profile->user->username,
        ];
    }
}