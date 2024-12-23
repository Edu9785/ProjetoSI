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
            'except' => ['login'],
        ];
        return $behaviors;
    }

    public $modelClass = 'common\models\Compra';

    public function actionCheckout()
    {

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $id_user = \Yii::$app->user->id;
        $profile = Profile::findOne(['id_user' => $id_user]);
        $carrinho = Carrinhocompra::findOne(['id_profile' => $profile->id]);
        $linhascarrinho = Linhacarrinho::find()->where(['id_carrinho' => $carrinho->id])->all();

        $model = new Compra();
        $model->id_profile = $profile->id;
        $model->datacompra = date('Y-m-d H:i:s');
        $model->precototal = $carrinho->precototal;

        $fatura = new Fatura();
        $fatura->id_profile = $profile->id;
        $fatura->datahora = $model->datacompra;

        if ($model->load(\Yii::$app->request->post(), '') && $model->save()) {
            $metodoexpedicao = Metodoexpedicao::findOne(['id' => $model->id_metodoexpedicao]);

            if ($metodoexpedicao) {
                $model->precototal += $metodoexpedicao->preco;
                $model->save();
            }

            $fatura->id_compra = $model->id;
            $fatura->precofatura = $model->precototal;
            $fatura->save();

            foreach ($linhascarrinho as $linha) {
                $linhacompra = new Linhacompra();
                $linhacompra->id_compra = $model->id;
                $linhacompra->id_produto = $linha->id_produto;
                $linhacompra->save();

                $linhafatura = new Linhafatura();
                $linhafatura->id_fatura = $fatura->id;
                $linhafatura->id_produto = $linha->id_produto;
                $linhafatura->save();

                $produto = Produto::findOne($linha->id_produto);
                if ($produto) {
                    $produto->estado = Produto::EM_ENTREGA;
                    $produto->save();
                }
            }

            foreach ($linhascarrinho as $linha) {
                $linha->delete();
            }

            Favorito::deleteAll(['id_user' => $profile->id]);

        }
        return $fatura;
    }
}