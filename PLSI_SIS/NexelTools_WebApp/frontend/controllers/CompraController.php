<?php

namespace frontend\controllers;

use common\models\Compra;
use common\models\Metodoexpedicao;
use common\models\Metodopagamento;
use common\models\Profile;
use frontend\models\Carrinhocompra;
use frontend\models\Linhacarrinho;
use Yii;
use yii\data\ActiveDataProvider;
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
                'access' => [
                    'class' => AccessControl::class,
                    'rules' => [
                        [
                            'allow' => true,
                            'actions' => ['index'],
                            'roles' => ['checkout'],
                        ],
                        [
                            'allow' => true,
                            'actions' => ['view'],
                            'roles' => ['checkout'],
                        ],
                        [
                            'allow' => true,
                            'actions' => ['create'],
                            'roles' => ['checkout'],
                        ],
                        [
                            'allow' => true,
                            'actions' => ['update'],
                            'roles' => ['checkout'],
                        ],
                        [
                            'allow' => true,
                            'actions' => ['delete'],
                            'roles' => ['checkout'],
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
        $id_user = Yii::$app->user->id;
        $profile = Profile::findOne(['id_user' => $id_user]);
        $carrinho = Carrinhocompra::findOne(['id_profile' => $profile->id]);
        $linhascarrinho = Linhacarrinho::find()->where(['id_carrinho' => $carrinho->id])->all();
        $metodoexpedicoes = Metodoexpedicao::find()->all();
        $metodopagamentos = Metodopagamento::find()->all();

        return $this->render('index', ['profile' => $profile,
            'carrinho' => $carrinho,
            'linhascarrinho' => $linhascarrinho,
            'metodoexpedicoes' => $metodoexpedicoes,
            'metodopagamentos' => $metodopagamentos,
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
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new compra model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate($tipometodo, $id_metodoexpedicao)
    {
        $id_user = \Yii::$app->user->id;
        $profile = Profile::findOne(['id_user' => $id_user]);
        $carrinho = Carrinhocompra::findOne(['id_prodile' => $profile->id]);
        $metodoexpedicao = Metodopagamento::findOne(['id' => $id_metodoexpedicao]);


        $model = new Compra();
        $model->id_profile = $profile->id;
        $model->datacompra = date('Y-m-d H:i:s');
        $model->precototal = $carrinho + $metodoexpedicao->preco;
        $model->id_metodopagamento =
        $model->id_metodoexpedicao = $id_metodoexpedicao;

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'profile' => $profile
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
