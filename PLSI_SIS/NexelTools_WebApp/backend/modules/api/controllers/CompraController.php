<?php

namespace backend\modules\api\controllers;

use common\models\Fatura;
use common\models\Linhacompra;
use common\models\Linhafatura;
use common\models\Metodoexpedicao;
use common\models\Produto;
use common\models\Profile;
use frontend\models\Carrinhocompra;
use frontend\models\Favorito;
use frontend\models\Linhacarrinho;
use yii\filters\auth\QueryParamAuth;
use yii\rest\ActiveController;
use common\models\Compra;

class CompraController extends ActiveController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => QueryParamAuth::className(),
        ];
        return $behaviors;
    }

    public $modelClass = 'common\models\Compra';

    public function actionCheckout()
    {
        $id_user = \Yii::$app->user->id;
        $profile = Profile::findOne(['id_user' => $id_user]);


        $carrinho = Carrinhocompra::findOne(['id_profile' => $profile->id]);
        $carrinho->precototal = 0;
        $carrinho->save();

        $linhascarrinho = Linhacarrinho::find()->where(['id_carrinho' => $carrinho->id])->all();
        if (empty($linhascarrinho)) {
            return ['error' => 'Carrinho is empty.'];
        }

        $data = \Yii::$app->request->post();

        $model = new Compra();
        $model->id_profile = $profile->id;
        $model->datacompra = date('Y-m-d H:i:s');
        $model->precototal = $carrinho->precototal;
        $model->id_metodopagamento = $data['id_metodopagamento'];
        $model->id_metodoexpedicao = $data['id_metodoexpedicao'];

        $fatura = new Fatura();
        $fatura->id_profile = $profile->id;
        $fatura->datahora = $model->datacompra;

        if (!$model->save()) {
            return ['error' => 'Falha na compra.'];
        }

        $metodoexpedicao = Metodoexpedicao::findOne(['id' => $model->id_metodoexpedicao]);
        if ($metodoexpedicao) {
            $model->precototal += $metodoexpedicao->preco;
        }

        $fatura->id_compra = $model->id;
        $fatura->precofatura = $model->precototal;
        if (!$fatura->save()) {
            return ['error' => 'Falha na faturação'];
        }

        foreach ($linhascarrinho as $linha) {
            $linhacompra = new Linhacompra();
            $linhacompra->id_compra = $model->id;
            $linhacompra->id_produto = $linha->id_produto;
            if (!$linhacompra->save()) {
                return ['error' => 'Falha na linha compra'];
            }

            $linhafatura = new Linhafatura();
            $linhafatura->id_fatura = $fatura->id;
            $linhafatura->id_produto = $linha->id_produto;
            if (!$linhafatura->save()) {
                return ['error' => 'Falha na linha fatura'];
            }

            $produto = Produto::findOne($linha->id_produto);
            if ($produto) {
                $produto->estado = Produto::EM_ENTREGA;
                if (!$produto->save()) {
                    return ['error' => 'Falha no estado do produto'];
                }
            }
        }

        foreach ($linhascarrinho as $linha) {
            $linha->delete();
        }

        Favorito::deleteAll(['id_user' => $profile->id]);

        return [
            'success' => true,
        ];
    }


    public function actionUsercompras()
    {
        $compraclass = new $this->modelClass;

        $id_user = \Yii::$app->user->id;
        $profile = Profile::findOne(['id_user' => $id_user]);

        $compras = $compraclass->find()->where(['id_profile' => $profile->id])->all();

        $usercompras = [];

        foreach ($compras as $compra) {
            $usercompras[] = [
                'id' => $compra->id,
                'precototal' => $compra->precototal,
                'metodoexpedicao' => $compra->metodoexpedicao->nome,
                'metodopagamento' => $compra->metodopagamento->nomemetodo,
                'datacompra' => $compra->datacompra,
                'id_profile' => $compra->id_profile,
            ];
        }

        return $usercompras;
    }

}