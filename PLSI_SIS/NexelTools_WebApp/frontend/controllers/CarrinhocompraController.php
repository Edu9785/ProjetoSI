<?php

namespace frontend\controllers;

use common\models\Produto;
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
 * CarrinhocompraController implements the CRUD actions for Carrinhocompra model.
 */
class CarrinhocompraController extends Controller
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
                            'roles' => ['addToCart'],
                        ],
                        [
                            'allow' => true,
                            'actions' => ['update'],
                            'roles' => ['editCart'],
                        ],
                        [
                            'allow' => true,
                            'actions' => ['delete'],
                            'roles' => ['removeFromCart'],
                        ],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Carrinhocompra models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $id_user = Yii::$app->user->id;
        $profile = Profile::findOne(['id_user' => $id_user]);
        $id_profile = $profile->id;
        $numLinhasCarrinho = 0;

        $carrinho = Carrinhocompra::findOne(['id_profile' => $id_profile]);

        if (!$carrinho) {
            $carrinho = new Carrinhocompra();
            $carrinho->id_profile = $profile->id;
            $carrinho->save();
        }

        $linhacarrinho = Linhacarrinho::find()->where(['id_carrinho' => $carrinho->id])
            ->with('produto')->all();

        $numLinhasCarrinho = Linhacarrinho::find()->where(['id_carrinho' => $carrinho->id])->count();
        Yii::$app->view->params['numLinhasCarrinho'] = $numLinhasCarrinho;

        return $this->render('index', [
            'linhacarrinho' => $linhacarrinho,
            'carrinho' => $carrinho,
            'numLinhasCarrinho' => $numLinhasCarrinho,
        ]);
    }

    /**
     * Displays a single Carrinhocompra model.
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
     * Creates a new Carrinhocompra model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate($id_produto)
    {
        $id_user = \Yii::$app->user->id;
        $profile = Profile::findOne(['id_user' => $id_user]);
        $id_comprador = $profile->id;

        $produto = Produto::findOne($id_produto);

        if ($produto->id_vendedor === $id_comprador) {
            \Yii::$app->session->setFlash('error', 'Você não pode adicionar o seu próprio produto ao carrinho.');
            return $this->redirect(['produto/index']);
        }

        $carrinho = Carrinhocompra::findOne(['id_profile' => $id_comprador]);

        if(!$carrinho){
            $carrinho = new Carrinhocompra();
            $carrinho->id_profile = $id_comprador;
            $carrinho->precototal = 0;
            $carrinho->save();
        }

        $linhacarrinho = Linhacarrinho::findOne(['id_carrinho' => $carrinho->id, 'id_produto' => $id_produto]);

        if($linhacarrinho){
           \Yii::$app->session->setFlash("info","O produto já se encontra no carrinho");
        }else{
            $linhacarrinho = new Linhacarrinho();
            $linhacarrinho->id_carrinho = $carrinho->id;
            $linhacarrinho->id_produto = $id_produto;

            if ($linhacarrinho->save()) {
                Yii::$app->session->setFlash('success', 'Produto adicionado ao carrinho.');
            } else {
                Yii::$app->session->setFlash('error', 'Erro ao adicionar o produto ao carrinho.');
            }
        }

        $carrinho->precototal = $this->calcularPrecoTotal($carrinho->id);
        $carrinho->save();

        return $this->redirect(['index']);
    }


    private function calcularPrecoTotal($id_carrinho){
        $linhasCarrinho = Linhacarrinho::find()->where(['id_carrinho' => $id_carrinho])->all();
        $total = 0;

        foreach ($linhasCarrinho as $linha){
            $produto = Produto::findOne([$linha->id_produto]);
            if($produto){
                $total += $produto->preco;
            }
        }

        return $total;
    }

    /**
     * Updates an existing Carrinhocompra model.
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
     * Deletes an existing Carrinhocompra model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id_linha)
    {
        $linha = Linhacarrinho::findOne(['id' => $id_linha]);
        $carrinho = $linha->carrinho;
        $carrinho->precototal -= $linha->produto->preco;
        $linha->delete();
        $carrinho->save();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Carrinhocompra model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Carrinhocompra the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Carrinhocompra::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
