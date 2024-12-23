<?php

namespace backend\modules\api\controllers;

use common\models\Produto;
use common\models\Profile;
use frontend\models\Linhacarrinho;
use yii\filters\auth\QueryParamAuth;
use yii\rest\ActiveController;
use frontend\models\Carrinhocompra;

class CarrinhocompraController extends ActiveController
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
    public $modelClass = 'frontend\models\Carrinhocompra';

    public function actionAdicionarproduto($id_produto){

        $id_user = \Yii::$app->user->id;
        $profile = Profile::findOne(['id_user' => $id_user]);
        $id_comprador = $profile->id;

        $produto = Produto::findOne($id_produto);

        if ($produto->id_vendedor == $id_comprador) {
            return null;
        }

        $carrinho = Carrinhocompra::findOne(['id_profile' => $id_comprador]);

        if(!$carrinho){
            $carrinho = new Carrinhocompra();
            $carrinho->id_profile = $id_comprador;
            $carrinho->precototal = 0;
            $carrinho->save();
        }

        $linhacarrinho = Linhacarrinho::findOne(['id_carrinho' => $carrinho->id, 'id_produto' => $id_produto]);

        if($linhacarrinho){
            return['message' => 'O produto já está no carrinho.'];
        }else{
            $linhacarrinho = new Linhacarrinho();
            $linhacarrinho->id_carrinho = $carrinho->id;
            $linhacarrinho->id_produto = $id_produto;
            $linhacarrinho->save();
        }

        $carrinho->precototal = $carrinho->calcularPrecoTotal($carrinho->id);
        $carrinho->save();

        $linhascarrinho = Linhacarrinho::findAll(['id_carrinho' => $carrinho->id]);

        return $linhascarrinho;
    }

    public function actionRemoverproduto($id_linha){

        $linha = Linhacarrinho::findOne(['id' => $id_linha]);
        $carrinho = $linha->carrinho;
        $carrinho->precototal -= $linha->produto->preco;
        $linha->delete();
        $carrinho->save();
        $linhascarrinho = Linhacarrinho::findAll(['id_carrinho' => $carrinho->id]);

        return $linhascarrinho;
    }
}