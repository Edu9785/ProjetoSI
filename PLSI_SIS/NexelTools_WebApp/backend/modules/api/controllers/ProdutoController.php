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
        ];
        return $behaviors;
    }


    public function actionProdutoimagens()
    {
        $produtos = Produto::find()->all();
        $produtoComImagem = [];

        foreach ($produtos as $produto) {
            $produtoCatalogo = [
                'id' => $produto->id,
                'nome' => $produto->nome,
                'desc' => $produto->desc,
                'preco' => $produto->preco,
                'vendedor' => $produto->profile->user->username,
                'id_tipo' => $produto->id_tipo,
                'estado' => $produto->estado,
                'id_vendedor' => $produto->profile->id,
                'imagens' => []
            ];

            $imagemProdutos = Imagemproduto::find()->where(['id_produto' => $produto->id])->all();

            foreach ($imagemProdutos as $imagemProduto) {

                $imagem = Imagem::findOne($imagemProduto->id_imagem);
                if ($imagem) {
                    $produtoCatalogo['imagens'][] = Yii::getAlias('@uploadsUrl') . '/' . basename($imagem->imagens);
                }
            }

            $produtoComImagem[] = $produtoCatalogo;
        }

        return $produtoComImagem;
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

        $profile = Profile::find()->where(['id' => $id_Vendedor])->one();

        $vendedor = $profile->user->username;

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

    public function actionCriarproduto()
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

        if (isset($data['imagens'])) {
            $imagensBase64 = json_decode($data['imagens'], true);

            foreach ($imagensBase64 as $encodedImage) {

                $nomeImagem = Yii::$app->security->generateRandomString() . '.png';
                $path = Yii::getAlias('@backend/web/uploads/' . $nomeImagem);

                if (file_put_contents($path, base64_decode($encodedImage))) {

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
        }

        return $produto;
    }


    public function actionEditarproduto($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $produto = $this->modelClass::findOne($id);

        if (!$produto) {
            return ['error' => 'Produto não encontrado'];
        }

        $request = Yii::$app->request;
        $data = $request->post();

        $produto->nome = $data['nome'] ?? $produto->nome;
        $produto->desc = $data['desc'] ?? $produto->desc;
        $produto->preco = $data['preco'] ?? $produto->preco;
        $produto->id_tipo = $data['id_tipo'] ?? $produto->id_tipo;

        $novasImagens = UploadedFile::getInstancesByName('imagens');

        if (!empty($novasImagens)) {
            // Buscar imagens antigas
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
            return [
                'success' => true,
                'produto' => $produto,
            ];
        }

        return ['error' => 'Erro ao salvar o produto', 'errors' => $produto->getErrors()];
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
            $linhaCarrinho->delete();
        }

        $favoritos = Favorito::find()->where(['id_produto' => $id])->all();
        foreach ($favoritos as $favorito) {
            $favorito->delete();
        }

        $deletar = Produto::deleteAll(['id' => $id]);

        return $deletar;
    }


    public function actionProdutoavender()
    {
        $id_user = Yii::$app->user->id;
        $profile = Profile::findOne(['id_user' => $id_user]);
        $produtos = Produto::find()->where(['id_vendedor' => $profile->id, 'estado' => Produto::DISPONIVEL])->all();

        $produtoAvender = [];

        foreach ($produtos as $produto) {
            $produtoVendedor = [
                'id' => $produto->id,
                'nome' => $produto->nome,
                'desc' => $produto->desc,
                'preco' => $produto->preco,
                'vendedor' => $produto->profile->user->username,
                'id_tipo' => $produto->id_tipo,
                'estado' => $produto->estado,
                'imagens' => []
            ];

            $imagemProdutos = Imagemproduto::find()->where(['id_produto' => $produto->id])->all();

            foreach ($imagemProdutos as $imagemProduto) {

                $imagem = Imagem::findOne($imagemProduto->id_imagem);
                if ($imagem) {
                    $produtoVendedor['imagens'][] = Yii::getAlias('@uploadsUrl') . '/' . basename($imagem->imagens);
                }
            }

            $produtoAvender[] = $produtoVendedor;
        }

        return $produtoAvender;
    }

    public function actionProdutosvendidos(){
        $id_user = Yii::$app->user->id;
        $profile = Profile::findOne(['id_user' => $id_user]);
        $produtos = Produto::find()
            ->where(['id_vendedor' => $profile->id])
            ->andWhere(['estado' => [Produto::EM_ENTREGA, Produto::ENTREGUE, Produto::EM_PROCESSAMENTO]])
            ->all();

        $produtosvendidos = [];

        foreach ($produtos as $produto) {
            $produtovendido = [
                'id' => $produto->id,
                'nome' => $produto->nome,
                'desc' => $produto->desc,
                'preco' => $produto->preco,
                'vendedor' => $produto->profile->user->username,
                'id_vendedor' => $produto->profile->id,
                'id_tipo' => $produto->id_tipo,
                'estado' => $produto->estado,
                'imagens' => []
            ];

            $imagemProdutos = Imagemproduto::find()->where(['id_produto' => $produto->id])->all();

            foreach ($imagemProdutos as $imagemProduto) {

                $imagem = Imagem::findOne($imagemProduto->id_imagem);
                if ($imagem) {
                    $produtovendido['imagens'][] = Yii::getAlias('@uploadsUrl') . '/' . basename($imagem->imagens);
                }
            }

            $produtosvendidos[] = $produtovendido;
        }

        return $produtosvendidos;
    }

    public function actionProdutodetalhes($id)
    {
        $produto = Produto::findOne(['id' => $id]);

        $produtoDetalhes = [
            'id' => $produto->id,
            'nome' => $produto->nome,
            'desc' => $produto->desc,
            'preco' => $produto->preco,
            'id_vendedor' => $produto->profile->id,
            'vendedor' => $produto->profile->user->username,
            'avaliacao' => $produto->profile->avaliacao,
            'imagens' => []
        ];

        $imagensProduto = Imagemproduto::find()->where(['id_produto' => $produto->id])->all();

        foreach ($imagensProduto as $imagemProduto) {
            $imagem = Imagem::findOne($imagemProduto->id_imagem);

            if ($imagem) {
                $produtoDetalhes['imagens'][] = Yii::getAlias('@uploadsUrl') . '/' . basename($imagem->imagens);
            }
        }

        return $produtoDetalhes;
    }


}

