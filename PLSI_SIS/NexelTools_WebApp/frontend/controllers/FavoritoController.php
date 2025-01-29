<?php

namespace frontend\controllers;

use common\models\Produto;
use frontend\models\Favorito;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\Profile;

/**
 * FavoritoController implements the CRUD actions for Favorito model.
 */
class FavoritoController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
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
                            'roles' => ['utilizador', '?'],
                        ],
                        [
                            'allow' => true,
                            'actions' => ['update'],
                            'roles' => ['utilizador'],
                        ],
                        [
                            'allow' => true,
                            'actions' => ['delete'],
                            'roles' => ['utilizador'],
                        ],
                    ],
                ],
            ]

        );
    }

    /**
     * Lists all Favorito models.
     *
     * @return string
     */
    public function actionIndex()
    {
       $favoritos = Favorito::find()->all();
       $numLinhasFavorito = Favorito::find()->count();
       Yii::$app->view->params['numLinhasFavorito'] = $numLinhasFavorito;

        return $this->render('index', [
            'favoritos' => $favoritos,
            'numLinhasFavorito' => $numLinhasFavorito,
        ]);
    }

    /**
     * Displays a single Favorito model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Favorito model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate($id_produto)
    {
        if (!Yii::$app->user->can('addFavorites')) {
            throw new \yii\web\ForbiddenHttpException('Não tem permissão para adicionar um produto aos favoritos.');
        }

        if(Yii::$app->user->isGuest){
            \Yii::$app->session->setFlash("info", "Faça Login para adicionar um Produto aos Favoritos.");
            return $this->redirect(['produto/index']);
        }

        $id_user = \Yii::$app->user->id;
        $profile = Profile::findOne(['id_user' => $id_user]);
        $id_comprador = $profile->id;

        $produto = Produto::findOne($id_produto);
        $produtoFavorito = Favorito::find()
            ->where(['id_produto' => $id_produto])
            ->one();

        if ($produto->id_vendedor == $id_comprador) {
            \Yii::$app->session->setFlash('error', 'Você não pode adicionar o seu próprio produto aos favoritos.');
            return $this->redirect(['produto/index']);
        }elseif ($produtoFavorito !== null){
            \Yii::$app->session->setFlash('error', 'O produto já se encontra na Lista de Favoritos.');
            return $this->redirect(['produto/index']);
        }

        $model = new Favorito();

        $model->id_user = $id_comprador;
        $model->id_produto = $id_produto;

        if($model->save()){
            Yii::$app->session->setFlash('success', 'Produto adicionado aos Favoritos.');
        } else {
            Yii::$app->session->setFlash('error', 'Erro ao adicionar o produto aos favoritos.');
        }



        return $this->redirect(['index']);
    }

    /**
     * Updates an existing Favorito model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        if (!Yii::$app->user->can('editFavorites')) {
            throw new \yii\web\ForbiddenHttpException('Não tem permissão para aceder a esta página.');
        }

        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Favorito model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        if (!Yii::$app->user->can('deleteFavorites')) {
            throw new \yii\web\ForbiddenHttpException('Não tem permissão para remover um favorito.');
        }

        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Favorito model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Favorito the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Favorito::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
