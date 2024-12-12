<?php

namespace backend\modules\api\controllers;

use common\models\Imagem;
use common\models\Imagemproduto;
use common\models\Produto;
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

    public function actionProcurarprodutocategoria($id_tipo)
    {
        $user = Yii::$app->user->identity;
        if (!$user) {
            return [
                'status' => 'error',
                'message' => 'Token de acesso inválido.',
            ];
        }

        $produtos = Produto::find()->where(['id_tipo' => $id_tipo])->all();

        if (empty($produtos)) {
            return [
                'status' => 'error',
                'message' => 'Nenhum produto encontrado para esta categoria.',
            ];
        }

        return [
            'status' => 'success',
            'produtos' => $produtos,
        ];
    }

    public function actionPublicarproduto()
    {
        $user = Yii::$app->user->identity;
        if (!$user) {
            return [
                'status' => 'error',
                'message' => 'Token de acesso inválido.',
            ];
        }

        $nome = Yii::$app->request->post('nome');
        $descricao = Yii::$app->request->post('desc');
        $preco = Yii::$app->request->post('preco');
        $id_tipo = Yii::$app->request->post('id_tipo');
        $id_vendedor = Yii::$app->request->post('id_vendedor');
        $imagens = UploadedFile::getInstancesByName('imagens');

        if (!$nome || !$descricao || !$preco || !$id_tipo || !$id_vendedor) {
            throw new BadRequestHttpException('Todos os campos são obrigatórios.');
        }

        $produto = new Produto();
        $produto->nome = $nome;
        $produto->desc = $descricao;
        $produto->preco = $preco;
        $produto->id_tipo = $id_tipo;
        $produto->id_vendedor = $id_vendedor;

        if (!$produto->save()) {
            return [
                'status' => 'error',
                'message' => 'Erro ao salvar o produto.',
                'errors' => $produto->errors,
            ];
        }

        if ($produto->validate() && $produto->save()) {
            foreach ($imagens as $imagem) {
                $nomeImagem = Yii::$app->security->generateRandomString() . '.' . $imagem->extension;
                $path = '@backend/web/uploads/' . $nomeImagem;

                if ($imagem->saveAs($path)) {

                    $imagemModel = new Imagem();
                    $imagemModel->imagens = 'uploads/'. $nomeImagem;

                    if ($imagemModel->validate() && $imagemModel->save()) {

                        $imagemprodutoModel = new Imagemproduto();
                        $imagemprodutoModel->id_produto = $produto->id;
                        $imagemprodutoModel->id_imagem = $imagemModel->id;

                        $imagemprodutoModel->save();
                    }
                }
            }
        }

        return [
            'status' => 'success',
            'message' => 'Produto publicado com sucesso!',
            'produto' => $produto,
        ];
    }
}

