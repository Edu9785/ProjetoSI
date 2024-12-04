<?php

namespace frontend\controllers;


use common\models\Categoria;
use common\models\Imagem;
use common\models\Imagemproduto;
use common\models\Produto;
use PHPUnit\TextUI\XmlConfiguration\Constant;
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
                            'roles' => ['?', '@'],
                        ],
                        [
                            'allow' => true,
                            'actions' => ['view'],
                            'roles' => ['?', '@'],
                        ],
                        [
                            'allow' => true,
                            'actions' => ['create'],
                            'roles' => ['createSales'],
                        ],
                        [
                            'allow' => true,
                            'actions' => ['update'],
                            'roles' => ['editSales'],
                        ],
                        [
                            'allow' => true,
                            'actions' => ['delete'],
                            'roles' => ['deleteSales'],
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
    public function actionCreate($id_vendedor)
    {
        $model = new Produto();
        $categorias = Categoria::find()->all();
        $model->id_vendedor = $id_vendedor;
        $model->estado = Produto::DISPONIVEL;

        if ($model->load(Yii::$app->request->post())) {

            $imagens = UploadedFile::getInstances($model, 'imagens');

            if ($model->validate() && $model->save()) {
                foreach ($imagens as $imagem) {
                    $nomeImagem = Yii::$app->security->generateRandomString() . '.' . $imagem->extension;
                    $path = '@backend/web/uploads/' . $nomeImagem;

                    if ($imagem->saveAs($path)) {

                        $imagemModel = new Imagem();
                        $imagemModel->imagens = 'uploads/'. $nomeImagem;

                        if ($imagemModel->validate() && $imagemModel->save()) {

                            $imagemprodutoModel = new Imagemproduto();
                            $imagemprodutoModel->id_produto = $model->id;
                            $imagemprodutoModel->id_imagem = $imagemModel->id;

                            $imagemprodutoModel->save();
                        }
                    }
                }
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'categorias' => ArrayHelper::map($categorias, 'id', 'tipo'),
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
        $model = Produto::findOne($id);
        $imagemproduto = Imagemproduto::find()->where(['id_produto' => $model->id])->all();

        if ($imagemproduto) {
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
        }

        $categorias = Categoria::find()->all();

        if ($model->load(Yii::$app->request->post())) {

            $imagens = UploadedFile::getInstances($model, 'imagens');

            if ($imagens) {
                foreach ($imagens as $imagem) {
                    $nomeImagem = Yii::$app->security->generateRandomString() . '.' . $imagem->extension;
                    $path = '@backend/web/uploads/' . $nomeImagem;

                    if ($imagem->saveAs($path)) {

                        $imagemModel = new Imagem();
                        $imagemModel->imagens = 'uploads/'. $nomeImagem;

                        if ($imagemModel->validate() && $imagemModel->save()) {

                            $imagemprodutoModel = new Imagemproduto();
                            $imagemprodutoModel->id_produto = $model->id;
                            $imagemprodutoModel->id_imagem = $imagemModel->id;
                            $imagemprodutoModel->save();
                        }
                    }
                }
            }
            if ($model->validate()) {
                if ($model->save()) {
                    return $this->redirect(['view', 'id' => $model->id]);
                }
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
