<?php

namespace backend\modules\api\controllers;

use common\models\Imagem;
use common\models\Imagemproduto;
use common\models\Produto;
use frontend\models\Favorito;
use frontend\models\Linhacarrinho;
use Yii;
use yii\filters\auth\QueryParamAuth;
use yii\rest\ActiveController;
use common\models\Profile;
use yii\web\BadRequestHttpException;
use yii\web\Response;
use yii\web\UploadedFile;

class ProdutoController extends ActiveController
{
    public $modelClass = 'common\models\Produto';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => QueryParamAuth::className(),
            'except' => ['login'],
        ];
        return $behaviors;
    }

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

    public function actionFiltrarpreco($max_preco)
    {
        $produtosclass = new $this->modelClass;
        $produtos = $produtosclass->find()->where(['<=', 'preco', $max_preco])->andWhere(['estado' => 0])->all();

        if(empty($produtos)){
            return[
                'message' => 'Nenhum produto encontrado!'
            ];
        }

        return $produtos;
    }

    public function actionCriarProduto()
    {
        $id_user = Yii::$app->user->id;
        $profile = Profile::findOne(['id_user' => $id_user]);
        $request = Yii::$app->request;
        $data = $request->post();

        $produto = new Produto();
        $produto->id_vendedor = $profile->id;
        $produto->nome = $data['nome'];
        $produto->desc = $data['desc'];
        $produto->preco = $data['preco'];
        $produto->id_tipo = $data['id_tipo'];
        $produto->estado = 0;
        $produto->save();


        $imagens = UploadedFile::getInstancesByName('imagens');
        foreach ($imagens as $imagem) {

            $nomeImagem = Yii::$app->security->generateRandomString() . '.' . $imagem->extension;
            $path = Yii::getAlias('@backend/web/uploads/' . $nomeImagem);

            if ($imagem->saveAs($path)) {
                $imagemModel = new Imagem();
                $imagemModel->imagens = 'uploads/' . $nomeImagem;

                if ($imagemModel->validate() && $imagemModel->save()) {
                    $imagemprodutoModel = new Imagemproduto();
                    $imagemprodutoModel->id_produto = $produto->id;
                    $imagemprodutoModel->id_imagem = $imagemModel->id;
                    $imagemprodutoModel->save();
                }
            }
        }

        return $produto;
    }

    public function actionEditarproduto($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $produto = $this->modelClass::findOne($id);

        if (!$produto) {
            return null;
        }

        $request = Yii::$app->request;
        $data = $request->post();

        $produto->nome = $data['nome'] ?? $produto->nome;
        $produto->desc = $data['desc'] ?? $produto->desc;
        $produto->preco = $data['preco'] ?? $produto->preco;
        $produto->id_tipo = $data['id_tipo'] ?? $produto->id_tipo;

        $novasImagens = UploadedFile::getInstancesByName('imagens');

        if ($novasImagens) {
            $imagemProdutos = Imagemproduto::find()->where(['id_produto' => $produto->id])->all();

            foreach ($imagemProdutos as $imagemProduto) {
                $imagem = Imagem::findOne($imagemProduto->id_imagem);

                if ($imagem) {
                    $path = Yii::getAlias('@backend/web/uploads/') . basename($imagem->imagens);
                    if (file_exists($path)) {
                        unlink($path);
                    }
                    $imagemProduto->delete();
                    $imagem->delete();
                }
            }

            foreach ($novasImagens as $novaImagem) {
                $nomeImagem = Yii::$app->security->generateRandomString() . '.' . $novaImagem->extension;
                $path = Yii::getAlias('@backend/web/uploads/') . $nomeImagem;

                if ($novaImagem->saveAs($path)) {
                    $imagemModel = new Imagem();
                    $imagemModel->imagens = 'uploads/' . $nomeImagem;

                    if ($imagemModel->validate() && $imagemModel->save()) {
                        $imagemProdutoModel = new Imagemproduto();
                        $imagemProdutoModel->id_produto = $produto->id;
                        $imagemProdutoModel->id_imagem = $imagemModel->id;
                        $imagemProdutoModel->save();
                    }
                }
            }
        }

        if ($produto->validate() && $produto->save()) {
            return $produto;
        }
        return null;
    }


    public function actionEliminarproduto($id)
    {
        $imagemProdutos = Imagemproduto::findAll(['id_produto' => $id]);
        foreach ($imagemProdutos as $imagemProduto) {
            $imagem = Imagem::findOne($imagemProduto->id_imagem);

            if ($imagem != null) {
                $path = Yii::getAlias('@backend/web/uploads/') . basename($imagem->imagens);
                if (file_exists($path)) {
                    unlink($path);
                }
                $imagemProduto->delete();
                $imagem->delete();
            }
        }

        $linhasCarrinho = Linhacarrinho::find()->where(['id_produto' => $id])->all();
        foreach ($linhasCarrinho as $linhaCarrinho) {
            $linhaCarrinho->delete();  // Remover do carrinho
        }

        $favoritos = Favorito::find()->where(['id_produto' => $id])->all();
        foreach ($favoritos as $favorito) {
            $favorito->delete();
        }

        $deletar = Produto::deleteAll(['id' => $id]);

        return $deletar;
    }


}

