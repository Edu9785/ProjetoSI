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
     * Lists all Carrinhocompra models.
     *
     * @return string
     */
    public function actionIndex()
    {
        if(!Yii::$app->user->isGuest){
            $id_user = Yii::$app->user->id;
            $profile = Profile::findOne(['id_user' => $id_user]);
            $id_profile = $profile->id;

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
        }else{
            $carrinho = null;
            $linhacarrinho = [];
            $numLinhasCarrinho = 0;
        }

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
        if (!Yii::$app->user->can('addToCart')) {
            throw new \yii\web\ForbiddenHttpException('Não tem permissão para adicionar ao carrinho.');
        }

        if(Yii::$app->user->isGuest){
            \Yii::$app->session->setFlash("info", "Faça Login para adicionar um Produto ao Carrinho.");
            return $this->redirect(['produto/index']);
        }

        $id_user = \Yii::$app->user->id;
        $profile = Profile::findOne(['id_user' => $id_user]);
        $id_comprador = $profile->id;

        $produto = Produto::findOne($id_produto);

        if ($produto->id_vendedor == $id_comprador) {
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

        $carrinho->precototal = $carrinho->calcularPrecoTotal($carrinho->id);
        $carrinho->save();

        return $this->redirect(['index']);
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
        if (!Yii::$app->user->can('editCart')) {
            throw new \yii\web\ForbiddenHttpException('Não tem permissão para editar um carrinho.');
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
     * Deletes an existing Carrinhocompra model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id_linha)
    {
        if (!Yii::$app->user->can('removeFromCart')) {
            throw new \yii\web\ForbiddenHttpException('Não tem permissão para remover um produto do carrinho.');
        }

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
