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
        ];
        return $behaviors;
    }
    public $modelClass = 'frontend\models\Carrinhocompra';

    public function actionUsercarrinho($id_profile){
        $carrinhoclass = new $this->modelClass;

        $id_user = \Yii::$app->user->id;
        $profile = Profile::findOne(['id_user' => $id_user]);

        $carrinho = $carrinhoclass->findOne(['id_profile' => $profile->id]);

        $linhas = Linhacarrinho::find()->where(['id_carrinho' => $carrinho->id])->all();

        return $linhas;
    }

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

    public function actionRemoverproduto($id_produto){
        $id_user = \Yii::$app->user->id;
        $profile = Profile::findOne(['id_user' => $id_user]);
        $carrinho = Carrinhocompra::findOne(['id_profile' => $profile->id]);
        $linha = Linhacarrinho::find()->where(['id_produto' => $id_produto])->andWhere(['id_carrinho' => $carrinho->id])->one();
        $carrinho->precototal -= $linha->produto->preco;
        $linha->delete();
        $carrinho->save();
        $linhascarrinho = Linhacarrinho::findAll(['id_carrinho' => $carrinho->id]);

        return $linhascarrinho;
    }
}