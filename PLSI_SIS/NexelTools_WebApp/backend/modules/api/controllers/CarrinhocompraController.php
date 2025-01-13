<?php

namespace backend\modules\api\controllers;

use common\models\Imagem;
use common\models\Imagemproduto;
use common\models\Produto;
use common\models\Profile;
use frontend\models\Linhacarrinho;
use Yii;
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

    public function actionUsercarrinho(){
        $carrinhoclass = new $this->modelClass;

        $id_user = \Yii::$app->user->id;
        $profile = Profile::findOne(['id_user' => $id_user]);

        $carrinho = $carrinhoclass->findOne(['id_profile' => $profile->id]);

        $linhas = Linhacarrinho::find()->where(['id_carrinho' => $carrinho->id])->all();

        $produtosCarrinho = [];

        foreach ($linhas as $linha) {
            $produto = Produto::findOne($linha->id_produto);
            $produtoCarrinho = [
                'id_produto' => $produto->id,
                'nome' => $produto->nome,
                'desc' => $produto->desc,
                'preco' => $produto->preco,
                'vendedor' => $produto->profile->user->username,
                'estado' => $produto->estado,
                'id_tipo' => $produto->id_tipo,
                'imagens' => [],
            ];

            $imagemProdutos = Imagemproduto::find()->where(['id_produto' => $produto->id])->all();
            foreach ($imagemProdutos as $imagemProduto) {
                $imagem = Imagem::findOne($imagemProduto->id_imagem);
                if ($imagem) {
                    $produtoCarrinho['imagens'][] = Yii::getAlias('@uploadsUrl') . '/' . basename($imagem->imagens);
                }
            }

            $produtosCarrinho[] = $produtoCarrinho;
        }

        return [
            'id' => $carrinho->id,
            'id_profile' => $profile->id,
            'produtos' => $produtosCarrinho,
            'precototal' => $carrinho->precototal
        ];
    }

    public function actionAdicionarproduto($id_produto){

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $id_user = \Yii::$app->user->id;
        $profile = Profile::findOne(['id_user' => $id_user]);
        $id_comprador = $profile->id;

        $produto = Produto::findOne($id_produto);

        if ($produto->id_vendedor == $id_comprador) {
            return ['message' => 'Você não pode adicionar seu próprio produto ao carrinho.'];
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
        }

        $linhacarrinho = new Linhacarrinho();
        $linhacarrinho->id_carrinho = $carrinho->id;
        $linhacarrinho->id_produto = $id_produto;
        $linhacarrinho->save();


        $carrinho->precototal = $carrinho->calcularPrecoTotal($carrinho->id);
        $carrinho->save();

        return['message' => 'Produto adicionado ao carrinho!'];


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