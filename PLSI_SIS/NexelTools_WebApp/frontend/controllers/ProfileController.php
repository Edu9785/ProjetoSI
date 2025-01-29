<?php

namespace frontend\controllers;

use common\models\Compra;
use common\models\Imagem;
use common\models\Imagemproduto;
use common\models\Linhafatura;
use common\models\Produto;
use common\models\Profile;
use common\models\User;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * ProfileController implements the CRUD actions for Profile model.
 */
class ProfileController extends Controller
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
                            'roles' => ['?'],
                        ],
                        [
                            'allow' => true,
                            'actions' => ['update'],
                            'roles' => ['utilizador'],
                        ],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Profile models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Profile::find(),
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
     * Displays a single Profile model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id){

        $profile = Profile::findOne((['id_user' => $id]));
        $compras = Compra::find()->where(['id_profile' => $profile->id])->all();
        $linhasFatura = Linhafatura::find()->all();

        $produtoVender = Produto::find()->where(['id_vendedor' => $profile])->all();
        $imagemUrls = [];

        $produtoVendedor = [];

        foreach($produtoVender as $venda){
            $imagemProduto = Imagemproduto::find()->where(['id_produto' => $venda->id])->one();

            if ($imagemProduto) {
                $imagem = Imagem::findOne($imagemProduto->id_imagem);
                if ($imagem) {
                    $imagemUrls[$venda->id] = Yii::getAlias('@uploadsUrl') . '/' . basename($imagem->imagens);
                }
            }
        }

       $produtosvendidos = Produto::find()->where(['id_vendedor' => $profile->id])->andWhere(['<>', 'estado', Produto::DISPONIVEL])->all();

        return $this->render('view', [
            'model' => $this->findModel($profile->id),
            'produtoVender' => $produtoVender,
            'imagemUrls' => $imagemUrls,
            'compras' => $compras,
            'produtosvendidos' => $produtosvendidos,
        ]);
    }

    /**
     * Creates a new Profile model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Profile();

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
     * Updates an existing Profile model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        if (!Yii::$app->user->can('editProfile')) {
            throw new \yii\web\ForbiddenHttpException('Não tem permissão para aceder a esta página.');
        }

        $model = $this->findModel($id);

        if ($this->request->isPost) {
            $model->load($this->request->post());
            $model->user->load($this->request->post());

            if ($model->validate() && $model->user->validate()) {
                $model->save();
                $model->user->save();

                return $this->redirect(['update', 'id' => Yii::$app->user->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }


    /**
     * Deletes an existing Profile model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Profile model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Profile the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Profile::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
