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

}

