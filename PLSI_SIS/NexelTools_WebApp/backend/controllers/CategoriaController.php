<?php

namespace backend\controllers;

use common\models\Categoria;
use common\models\Imagem;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * CategoriaController implements the CRUD actions for Categoria model.
 */
class CategoriaController extends Controller
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
     * Lists all Categoria models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Categoria::find(),
            /*
            'pagination' => [
                'pageSize' => 50
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
            */
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Categoria model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $imagem = Imagem::findOne($model->id_imagem);

        if($imagem){
            $urlImagem = Yii::getAlias('@web/uploads') . '/' . basename($imagem->imagens);
        }else{
            $urlImagem = null;
        }
        return $this->render('view', [
            'model' => $model,
            'urlImagem' => $urlImagem,
        ]);
    }

    /**
     * Creates a new Categoria model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        if (!Yii::$app->user->can('addcategories')) {
            throw new \yii\web\ForbiddenHttpException('Não tem permissão para adicionar categorias.');
        }

        $model = new Categoria();

        if ($model->load(Yii::$app->request->post())) {
            $model->imagemCat = UploadedFile::getInstance($model, 'imagemCat');

            if ($model->imagemCat) {
                $nomeImagem = Yii::$app->security->generateRandomString() . '.' . $model->imagemCat->extension;
                $caminhoImagem = 'uploads/' . $nomeImagem;

                if ($model->imagemCat->saveAs($caminhoImagem)) {

                    $imagem = new Imagem();
                    $imagem->imagens = $caminhoImagem;

                    if ($imagem->save()) {
                        $model->id_imagem = $imagem->id;
                    }
                }
            }
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('create', ['model' => $model]);
    }



    /**
     * Updates an existing Categoria model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */

    public function actionUpdate($id)
    {
        if (!Yii::$app->user->can('editCategories')) {
            throw new \yii\web\ForbiddenHttpException('Não tem permissão para editar categorias.');
        }

        $model = $this->findModel($id);
        $imagem = Imagem::findOne($model->id_imagem);

        if ($this->request->isPost && $model->load($this->request->post())) {
            $ficheiro = UploadedFile::getInstance($model, 'imagemCat');

            if ($ficheiro) {
                if ($imagem !== null) {
                    $path = $imagem->imagens;

                    if(file_exists($path)){
                        unlink($path);
                    }
                    $imagem->delete();
                }

                $nomeImagem = Yii::$app->security->generateRandomString() . '.' . $ficheiro->extension;
                $caminho = Yii::getAlias('@uploads') . '/' . $nomeImagem;

                $imagem = new Imagem();
                $imagem->imagens = 'uploads/' . $nomeImagem;

                if ($imagem->save()) {
                    $ficheiro->saveAs($caminho);
                    $model->id_imagem = $imagem->id;
                }
            }

            if (!$ficheiro && $imagem !== null) {
                $model->id_imagem = $imagem->id;
            }

            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }






    /**
     * Deletes an existing Categoria model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        if (!Yii::$app->user->can('deletecategories')) {
            Yii::$app->session->setFlash('error', "Não tem permissão para aceder a esta página");
            return $this->goBack();
        }

        $categoria = $this->findModel($id);

        if($categoria != null){
            $imagem = Imagem::findOne($categoria->id_imagem);

            if($imagem != null){
                $path = $imagem->imagens;

                if(file_exists($path)){
                    unlink($path);
                }
                $imagem->delete();
            }

            $categoria->delete();
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the Categoria model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Categoria the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Categoria::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
