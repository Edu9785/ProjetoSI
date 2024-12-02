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
    public function actionCreate($id_vendedor)
    {
        $model = new Produto();
        $categorias = Categoria::find()->all();
        $model->id_vendedor = $id_vendedor;
        $uploadsPath = Yii::getAlias('@backend/web/uploads');
        // Verifica se o diretório de uploads existe e tem permissão de escrita
        if (!is_dir($uploadsPath) || !is_writable($uploadsPath)) {
            Yii::error("O diretório 'uploads/' não existe ou não tem permissões de escrita.");
            throw new \Exception("O diretório 'uploads/' não está acessível.");
        }

        echo 'Entrou no actionCreate<br>';

        if ($model->load(Yii::$app->request->post())) {
            echo 'Carregou os dados do POST<br>';

            $imagens = UploadedFile::getInstances($model, 'imagens');
            echo 'Número de imagens carregadas: ' . count($imagens) . '<br>';

            if ($model->validate() && $model->save()) {
                echo 'Produto salvo com sucesso: ID ' . $model->id . '<br>';

                foreach ($imagens as $imagem) {
                    echo 'Processando imagem: ' . $imagem->name . '<br>';

                    // Gera um nome único para o arquivo
                    $uniqueName = Yii::$app->security->generateRandomString() . '.' . $imagem->extension;
                    $path = '@backend/web/uploads/' . $uniqueName;

                    // Tenta salvar a imagem no diretório
                    if ($imagem->saveAs($path)) {
                        echo 'Imagem salva no servidor: ' . $path . '<br>';

                        $imagemModel = new Imagem();
                        $imagemModel->imagens = $path;

                        if ($imagemModel->validate() && $imagemModel->save()) {
                            echo 'Imagem salva no banco de dados: ID ' . $imagemModel->id . '<br>';

                            $imagemprodutoModel = new Imagemproduto();
                            $imagemprodutoModel->id_produto = $model->id;
                            $imagemprodutoModel->id_imagem = $imagemModel->id;

                            if ($imagemprodutoModel->validate() && $imagemprodutoModel->save()) {
                                echo 'Relacionamento salvo com sucesso para Produto ID ' . $model->id . ' e Imagem ID ' . $imagemModel->id . '<br>';
                            } else {
                                Yii::error("Erro ao salvar o relacionamento Imagemproduto: " . json_encode($imagemprodutoModel->getErrors()));
                                echo 'Erro ao salvar o relacionamento Imagemproduto<br>';
                            }
                        } else {
                            Yii::error("Erro ao salvar a Imagem: " . json_encode($imagemModel->getErrors()));
                            echo 'Erro ao salvar a Imagem no banco de dados<br>';
                        }
                    } else {
                        Yii::error("Erro ao salvar a imagem no diretório: " . $path);
                        echo 'Erro ao salvar a imagem no diretório<br>';
                    }
                }

                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                Yii::error("Erro ao validar ou salvar o Produto: " . json_encode($model->getErrors()));
                echo 'Erro ao validar ou salvar o Produto<br>';
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
