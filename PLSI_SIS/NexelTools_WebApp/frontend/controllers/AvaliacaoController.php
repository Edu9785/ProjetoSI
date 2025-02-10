<?php

namespace frontend\controllers;

use common\models\Avaliacao;
use common\models\Compra;
use common\models\Imagem;
use common\models\Imagemproduto;
use common\models\Linhacompra;
use common\models\Produto;
use common\models\Profile;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * AvaliacaoController implements the CRUD actions for Avaliacao model.
 */
class AvaliacaoController extends Controller
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
                            'roles' => ['leaveReview'],
                        ],
                        [
                            'allow' => true,
                            'actions' => ['update'],
                            'roles' => ['editReview'],
                        ],
                        [
                            'allow' => true,
                            'actions' => ['delete'],
                            'roles' => ['deleteReview'],
                        ],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Avaliacao models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Avaliacao::find(),
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
     * Displays a single Avaliacao model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id_produto)
    {
        $model = Avaliacao::findOne(['id_produto' => $id_produto]);
        $produto = Produto::findOne(['id' => $id_produto]);
        $imagemUrls = [];

        $imagensProduto = Imagemproduto::find()->where(['id_produto' => $id_produto])->all();
        foreach ($imagensProduto as $imagemProduto) {
            $imagem = Imagem::findOne($imagemProduto->id_imagem);
            if ($imagem) {
                $imagemUrls[] = \Yii::getAlias('@uploadsUrl') . '/' . basename($imagem->imagens);
            }
        }

        return $this->render('view', [
            'model' => $model,
            'imagemUrls' => $imagemUrls,
            'produto' => $produto,
        ]);
    }

    /**
     * Creates a new Avaliacao model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate($id_produto)
    {
        if (!Yii::$app->user->can('leaveReview')) {
            throw new \yii\web\ForbiddenHttpException('Não tem permissão para publicar uma avaliação.');
        }

        $id_user = \Yii::$app->user->id;
        $profile = Profile::findOne(['id_user' => $id_user]);
        $produto = Produto::findOne(['id' => $id_produto]);


        $model = new Avaliacao();
        $model->id_user = $profile->id;
        $model->id_produto = $id_produto;

        $imagemUrls = [];

        $imagensProduto = Imagemproduto::find()->where(['id_produto' => $id_produto])->all();
        foreach ($imagensProduto as $imagemProduto) {
            $imagem = Imagem::findOne($imagemProduto->id_imagem);
            if ($imagem) {
                $imagemUrls[] = \Yii::getAlias('@uploadsUrl') . '/' . basename($imagem->imagens);
            }
        }

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->validate() && $model->save()) {

                $profile = Profile::findOne(['id' => $produto->profile->id]);
                $profile->avaliacao = Avaliacao::mediaAvaliacao($profile->id);
                $profile->save();
                return $this->redirect(['view', 'id_produto' => $model->produto->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'produto' => $produto,
            'imagemUrls' => $imagemUrls,
        ]);
    }


    /**
     * Updates an existing Avaliacao model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        if (!Yii::$app->user->can('editReview')) {
            throw new \yii\web\ForbiddenHttpException('Não tem permissão para editar uma avaliação.');
        }

        $model = $this->findModel($id);
        $produto = Produto::findOne($model->id_produto);

        $imagemUrls = [];
        $imagensProduto = Imagemproduto::find()->where(['id_produto' => $model->id_produto])->all();
        foreach ($imagensProduto as $imagemProduto) {
            $imagem = Imagem::findOne($imagemProduto->id_imagem);
            if ($imagem) {
                $imagemUrls[] = \Yii::getAlias('@uploadsUrl') . '/' . basename($imagem->imagens);
            }
        }

        if ($this->request->isPost && $model->load($this->request->post()) && $model->validate()) {
            if ($model->save()) {

                $profile = Profile::findOne(['id' => $produto->profile->id]);
                $profile->avaliacao = Avaliacao::mediaAvaliacao($profile->id);
                $profile->save();

                return $this->redirect(['view', 'id_produto' => $model->produto->id]);
            }
        }

        $model->loadDefaultValues();

        return $this->render('update', [
            'model' => $model,
            'produto' => $produto,
            'imagemUrls' => $imagemUrls,
        ]);
    }


    /**
     * Deletes an existing Avaliacao model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        if (!Yii::$app->user->can('deleteReview')) {
            throw new \yii\web\ForbiddenHttpException('Não tem permissão para eliminar uma avaliação.');
        }

        $avaliacao = $this->findModel($id);
        $id_produto = $avaliacao->produto->id;
        $linhacompra = Linhacompra::findOne(['id_produto' => $id_produto]);
        $compra = Compra::findOne(['id' => $linhacompra->compra->id]);

        $avaliacao->delete();

        return $this->redirect(['compra/view', 'id' => $compra->id]);
    }

    /**
     * Finds the Avaliacao model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Avaliacao the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Avaliacao::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
