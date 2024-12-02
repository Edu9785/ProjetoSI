<?php

namespace frontend\controllers;


use common\models\Categoria;
use common\models\Imagem;
use common\models\Imagemproduto;
use common\models\Produto;
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
        $dataProvider = new ActiveDataProvider([
            'query' => Produto::find(),
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
     * Displays a single Produto model.
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
     * Creates a new Produto model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Produto();
        $categorias = Categoria::find()->all();
        echo 'entrei no create';
        if ($model->load(Yii::$app->request->post())) {
            $imagens = UploadedFile::getInstances($model, 'imagens');
            if ($model->validate() && $model->save()) {
                foreach ($imagens as $imagem) {

                    $uniqueName = Yii::$app->security->generateRandomString() . '.' . $imagem->extension;

                    $path = 'uploads/' . $uniqueName;

                    if ($imagem->saveAs($path)) {
                        $imagemModel = new Imagem();
                        $imagemModel->caminho = $path;
                        if ($imagemModel->save()) {
                            echo 'Imagem salva com sucesso: ' . $path;
                            $imagemprodutoModel = new Imagemproduto();

                            $imagemprodutoModel->id_produto = $model->id;
                            $imagemprodutoModel->id_imagem = $imagemModel->id;

                            $imagemprodutoModel->save();

                        }
                    }
                }

                return $this->redirect(['view', 'id' => $model->id]);
            }
            else
            {
                Yii::error("Erro na validação ou no salvamento do produto.");
            }
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
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
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
