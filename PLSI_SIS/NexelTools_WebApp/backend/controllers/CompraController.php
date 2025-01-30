<?php

namespace backend\controllers;

use common\models\Compra;
use common\models\Linhacompra;
use common\models\Produto;
use Yii;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * CompraController implements the CRUD actions for compra model.
 */
class CompraController extends Controller
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
                            'actions' => ['enviar'],
                            'roles' => ['admin'],
                        ],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all compra models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Compra::find(),
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
     * Displays a single compra model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {

        if (!Yii::$app->user->can('accessBackOffice')) {
            throw new \yii\web\ForbiddenHttpException('Não tem permissão para aceder a esta página.');
        }

        $produtosCompra = Linhacompra::find()->where(['id_compra' => $id])->all();

        $dataProvider = new ArrayDataProvider([
            'allModels' => $produtosCompra,
            'pagination' => false,
        ]);


        return $this->render('view', [
            'model' => $this->findModel($id),
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionEnviar($id)
    {

        if (!Yii::$app->user->can('accessBackOffice')) {
            throw new \yii\web\ForbiddenHttpException('Não tem permissão para fazer esta ação.');
        }

        $produtosCompra = Linhacompra::find()->where(['id_compra' => $id])->all();

        foreach ($produtosCompra as $produtoCompra){
            $produtoCompra->produto->estado = Produto::EM_ENTREGA;
            $produtoCompra->produto->save();
        }


        return $this->redirect('index');
    }

    /**
     * Creates a new compra model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        if (!Yii::$app->user->can('makePurchase')) {
            throw new \yii\web\ForbiddenHttpException('Não tem permissão para fazer uma compra.');
        }

        $model = new Compra();

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
     * Updates an existing compra model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing compra model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        if (!Yii::$app->user->can('accessBackOffice')) {
            throw new \yii\web\ForbiddenHttpException('Não tem permissão para aceder eliminar uma compra.');
        }

        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the compra model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Compra the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Compra::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
