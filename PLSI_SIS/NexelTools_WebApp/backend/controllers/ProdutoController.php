<?php

namespace backend\controllers;

use common\models\Categoria;
use common\models\Imagem;
use common\models\Imagemproduto;
use common\models\Produto;
use frontend\models\Favorito;
use frontend\models\Linhacarrinho;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * ProdutoController implements the CRUD actions for Produto model.
 */
class ProdutoController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
                'access' => [
                    'class' => AccessControl::class,
                    'rules' => [
                        [
                            'allow' => true,
                            'actions' => ['index'],
                            'roles' => ['@'],
                        ],
                        [
                            'allow' => true,
                            'actions' => ['view'],
                            'roles' => ['@'],
                        ],
                        [
                            'allow' => true,
                            'actions' => ['create'],
                            'roles' => ['admin'],
                        ],
                        [
                            'allow' => true,
                            'actions' => ['update'],
                            'roles' => ['admin'],
                        ],
                        [
                            'allow' => true,
                            'actions' => ['delete'],
                            'roles' => ['admin'],
                        ],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Produto models.
     *
     * @return string
     */
    public function actionIndex()
    {
        if (!Yii::$app->user->can('accessBackOffice')) {
            throw new \yii\web\ForbiddenHttpException('Não tem permissão para ver os Produtos');
        }

        $produtos = Produto::find()->all();
        $imagemUrls = [];

        foreach($produtos as $produto){
            $imagemProduto = Imagemproduto::find()->where(['id_produto' => $produto->id])->one();

            if ($imagemProduto) {
                $imagem = Imagem::findOne($imagemProduto->id_imagem);
                if ($imagem) {
                    $imagemUrls[$produto->id] = Yii::getAlias('@uploadsUrl') . '/' . basename($imagem->imagens);
                }
            }
        }

        return $this->render('index', [
            'produtos' => $produtos,
            'imagemUrls' => $imagemUrls,
        ]);
    }

    /**
     * Displays a single Produto model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        if (!Yii::$app->user->can('viewProductDetails')) {
            throw new \yii\web\ForbiddenHttpException('Não tem permissão para ver os detalhes do produto');
        }

        $model = $this->findModel($id);

        $imagens = Imagemproduto::find()->where(['id_produto' => $model->id])->all();
        $imagemUrls = [];

        foreach ($imagens as $imagem) {
            $img = Imagem::findOne($imagem->id_imagem);
            if ($img) {
                $imagemUrls[] = Yii::getAlias('@uploadsUrl') . '/' . basename($img->imagens);
            }
        }

        return $this->render('view', [
            'model' => $model,
            'imagemUrls' => $imagemUrls,
        ]);
    }

    /**
     * Creates a new Produto model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        if (!Yii::$app->user->can('createSales')) {
            throw new \yii\web\ForbiddenHttpException('Não tem permissão para editar a Avaliação.');
        }

        $model = new Produto();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Produto model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {

        if (!Yii::$app->user->can('editSales')) {
            throw new \yii\web\ForbiddenHttpException('Não tem permissão para editar um produto.');
        }

        $model = Produto::findOne($id);

        $imagemproduto = Imagemproduto::find()->where(['id_produto' => $model->id])->all();
        $categorias = Categoria::find()->all();

        if ($model->load(Yii::$app->request->post())) {
            $novasImagens = UploadedFile::getInstances($model, 'imagens');

            if ($novasImagens) {
                foreach ($imagemproduto as $imagemprodutos) {
                    $imagemdelete = Imagem::findOne($imagemprodutos->id_imagem);

                    if ($imagemdelete) {
                        $pathdelete = Yii::getAlias('@backend/web/uploads/') . basename($imagemdelete->imagens);
                        if (file_exists($pathdelete)) {
                            unlink($pathdelete);
                        }
                        $imagemprodutos->delete();
                        $imagemdelete->delete();
                    }
                }

                foreach ($novasImagens as $imagem) {
                    $nomeImagem = Yii::$app->security->generateRandomString() . '.' . $imagem->extension;
                    $path = Yii::getAlias('@backend/web/uploads/') . $nomeImagem;

                    if ($imagem->saveAs($path)) {
                        $imagemModel = new Imagem();
                        $imagemModel->imagens = 'uploads/' . $nomeImagem;

                        if ($imagemModel->validate() && $imagemModel->save()) {
                            $imagemprodutoModel = new Imagemproduto();
                            $imagemprodutoModel->id_produto = $model->id;
                            $imagemprodutoModel->id_imagem = $imagemModel->id;
                            $imagemprodutoModel->save();
                        }
                    }
                }
            }

            if ($model->validate() && $model->save()) {
                Yii::$app->session->setFlash('success', 'Produto atualizado com sucesso.');
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                Yii::$app->session->setFlash('error', 'Erro ao atualizar o produto.');
            }
        }

        return $this->render('update', [
            'model' => $model,
            'categorias' => ArrayHelper::map($categorias, 'id', 'tipo'),
        ]);
    }

    /**
     * Deletes an existing Produto model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {

        if (!Yii::$app->user->can('deleteSales')) {
            throw new \yii\web\ForbiddenHttpException('Não tem permissão para eliminar um produto.');
        }

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

        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Produto model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Produto the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Produto::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
