<?php

namespace frontend\controllers;

use common\models\Compra;
use common\models\Fatura;
use common\models\Linhacompra;
use common\models\Linhafatura;
use common\models\Metodoexpedicao;
use common\models\Metodopagamento;
use common\models\Produto;
use common\models\Profile;
use frontend\models\Carrinhocompra;
use frontend\models\Favorito;
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
                            'roles' => ['utilizador'],
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
                        [
                            'allow' => true,
                            'actions' => ['confirmar-entrega'],
                            'roles' => ['utilizador'],
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
        $linhascompra = Linhacompra::find()->where(['id_compra' => $id])->all();

        return $this->render('view', [
            'model' => $this->findModel($id),
            'linhascompra' => $linhascompra,
        ]);
    }

    /**
     * Creates a new compra model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        if (!Yii::$app->user->can('checkout')) {
            throw new \yii\web\ForbiddenHttpException('Não tem permissão para fazer uma compra.');
        }



        $id_user = \Yii::$app->user->id;
        $profile = Profile::findOne(['id_user' => $id_user]);
        $carrinho = Carrinhocompra::findOne(['id_profile' => $profile->id]);
        $metodoexpedicoes = Metodoexpedicao::find()->all();
        $metodopagamentos = Metodopagamento::find()->all();
        $linhascarrinho = Linhacarrinho::find()->where(['id_carrinho' => $carrinho->id])->all();
        $favoritos = Favorito::find()->where(['id_user' => $profile->id])->all();

        if($carrinho->precototal == 0){
            Yii::$app->session->setFlash('error', 'Não tem produtos no carrinho!');
            return $this->redirect(['carrinhocompra/index']);
        }

        $model = new Compra();
        $model->id_profile = $profile->id;
        $model->datacompra = date('Y-m-d H:i:s');
        $model->precototal = $carrinho->precototal;

        $fatura = new Fatura();
        $fatura->id_profile = $profile->id;
        $fatura->datahora = $model->datacompra;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $metodoexpedicao = Metodoexpedicao::findOne(['id' => $model->id_metodoexpedicao]);
            $model->precototal += $metodoexpedicao->preco;
            $model->save();
            $fatura->id_compra = $model->id;
            $fatura->precofatura = $model->precototal;
            $fatura->save();

            foreach ($linhascarrinho as $linha) {
                $linhacompra = new Linhacompra();
                $linhacompra->id_compra = $model->id;
                $linhacompra->id_produto = $linha->id_produto;
                $linhacompra->save();

                $linhafatura = new Linhafatura();
                $linhafatura->id_fatura = $fatura->id;
                $linhafatura->id_produto = $linha->id_produto;
                $linhafatura->save();

                $produto = Produto::findOne($linha->id_produto);
                if ($produto) {
                    $produto->estado = Produto::EM_PROCESSAMENTO;
                    $produto->save();
                }
            }

            foreach ($linhascarrinho as $linha) {
                $linha->delete();
            }
            foreach ($favoritos as $favorito) {
                $favorito->delete();
            }
            Yii::$app->session->setFlash('success', 'Compra realizada com sucesso! Obrigado!');
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'profile' => $profile,
            'metodoexpedicoes' => $metodoexpedicoes,
            'metodopagamentos' => $metodopagamentos,
            'linhascarrinho' => $linhascarrinho,
            'carrinho' => $carrinho,
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

    public function actionConfirmarEntrega($id_produto)
    {
        $produto = Produto::findOne(['id' => $id_produto]);

        if ($produto) {
            $produto->estado = Produto::ENTREGUE;
            $produto->save(false);

            $linhacompra = Linhacompra::findOne(['id_produto' => $produto->id]);

            if ($linhacompra) {
                $compra = Compra::findOne(['id' => $linhacompra->id_compra]);

                if ($compra) {
                    Yii::$app->session->setFlash('success', 'Produto confirmado como entregue.');
                    return $this->redirect(['view', 'id' => $compra->id]);
                }
            }
        }

        Yii::$app->session->setFlash('error', 'Erro ao confirmar a entrega do produto.');
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
