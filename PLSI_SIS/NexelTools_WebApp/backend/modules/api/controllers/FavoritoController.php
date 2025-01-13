<?php

namespace backend\modules\api\controllers;

use common\models\Imagem;
use common\models\Imagemproduto;
use common\models\Produto;
use common\models\Profile;
use Yii;
use yii\filters\auth\QueryParamAuth;
use yii\rest\ActiveController;
use frontend\models\Favorito;

class FavoritoController extends ActiveController
{
    public $modelClass = 'frontend\models\Favorito';
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => QueryParamAuth::className(),
        ];
        return $behaviors;
    }


    public function actionUserfavoritos()
    {
        $id_user = \Yii::$app->user->id;
        $profile = Profile::findOne(['id_user' => $id_user]);
        $favoritoclass = new $this->modelClass;

        $userfavoritos = $favoritoclass->find()->where(['id_user' => $profile->id])->all();

        $produtosFavoritos = [];

        foreach ($userfavoritos as $favorito) {
            $produto = Produto::findOne($favorito->id_produto);

            if ($produto) {
                $produtoFavorito = [
                    'id' => $favorito->id,
                    'id_produto' => $produto->id,
                    'id_user' => $profile->id,
                    'nome' => $produto->nome,
                    'vendedor' => $produto->profile->user->username,
                    'preco' => $produto->preco,
                    'imagens' => []
                ];

                $imagemProdutos = Imagemproduto::find()->where(['id_produto' => $produto->id])->all();

                foreach ($imagemProdutos as $imagemProduto) {
                    $imagem = Imagem::findOne($imagemProduto->id_imagem);
                    if ($imagem) {
                        $produtoFavorito['imagens'][] = Yii::getAlias('@uploadsUrl') . '/' . basename($imagem->imagens);
                    }
                }

                $produtosFavoritos[] = $produtoFavorito;
            }
        }

        return $produtosFavoritos;
    }

    public function actionAddfavorito($id_produto){

        $id_user = \Yii::$app->user->id;
        $profile = Profile::findOne(['id_user' => $id_user]);
        $produto = Produto::findOne(['id' => $id_produto]);
        if($produto->id_vendedor == $profile->id){
            return[
                'message' => 'Não pode adicionar um produto seu aos favoritos!'
            ];
        }

        $favorito = Favorito::findOne(['id_user' => $profile->id, 'id_produto' => $id_produto]);

        if($favorito){
            return['message' => 'O produto já está na lista de favoritos.'];
        }else{
            $favorito = new Favorito();
            $favorito->id_user = $profile->id;
            $favorito->id_produto = $id_produto;
            $favorito->save();
        }

        return['message' => 'Produto adicionado aos favoritos.'];
    }

    public function actionRemoverfavorito($id_produto){

        $favoritoclass = new $this->modelClass();
        $id_user = \Yii::$app->user->id;
        $profile = Profile::findOne(['id_user' => $id_user]);

        $remover = $favoritoclass->find()->where(['id_produto' => $id_produto, 'id_user' => $profile->id])->one();

        $remover->delete();

        return['message' => 'Produto removido dos favoritos.'];
    }
}