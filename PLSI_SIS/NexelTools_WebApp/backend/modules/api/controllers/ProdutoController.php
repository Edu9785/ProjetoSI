<?php

namespace backend\modules\api\controllers;

use common\models\Produto;
use yii\rest\ActiveController;
use common\models\Profile;

class ProdutoController extends ActiveController
{
    public $modelClass = 'common\models\Produto';

    public function actionNome($nome){
        $produtosclass = new $this->modelClass;
        $produtos = $produtosclass->find()->where(['nome' => $nome])->all();
        return $produtos;
    }

    public function actionProcurarvendedor($id)
    {
        $produto = Produto::find()->where(['id' => $id])->one();

        if (!$produto) {
            return [
                'status' => 'error',
                'message' => 'Produto não encontrado.',
            ];
        }

        $id_Vendedor = $produto->id_vendedor;

        $vendedor = Profile::find()->where(['id' => $id_Vendedor])->one();


        if ($vendedor) {
            return $vendedor;
        } else {
            return [
                'status' => 'error',
                'message' => 'Vendedor não encontrado.',
            ];
        }
    }
}

