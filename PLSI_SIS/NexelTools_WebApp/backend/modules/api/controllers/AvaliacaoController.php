<?php

namespace backend\modules\api\controllers;

use common\models\Produto;
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
        ];
        return $behaviors;
    }
    public function actionAvaliacaoproduto($id_produto)
    {
        $avaliacaoclass = new $this->modelClass;

        $avaliacao = $avaliacaoclass->find()->where(['id_produto' => $id_produto])->all();

        return $avaliacao;
    }

    public function actionVendedoravaliacoes($id_vendedor){

        $avaliacaoclass = new $this->modelClass;

        $produtosVendedor = Produto::find()->where(['id_vendedor' => $id_vendedor])->all();
        $avaliacoesVendedor = [];

        foreach ($produtosVendedor as $produto) {
            $reviews = $avaliacaoclass->find()->where(['id_produto' => $produto->id])->all();

            foreach ($reviews as $review) {
                $avaliacoesVendedor[] = [
                    'id' => $review->id,
                    'comentario' => $review->desc,
                    'avaliacao' => $review->avaliacao,
                    'username' => $review->profile->user->username,
                ];
            }
        }

        return $avaliacoesVendedor;
    }
}