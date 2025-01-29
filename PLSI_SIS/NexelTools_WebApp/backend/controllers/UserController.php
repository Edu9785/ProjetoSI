<?php

namespace backend\controllers;

use common\models\User;
use common\models\Profile;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
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
                            'actions' => ['update'],
                            'roles' => ['editUsers'],
                        ],
                        [
                            'allow' => true,
                            'actions' => ['delete'],
                            'roles' => ['deleteUsers'],
                        ],
                        [
                            'allow' => true,
                            'actions' =>['promote', 'demote'],
                            'roles' => ['assignRoles']
                        ]

                    ]
                ]
            ]
        );
    }

    /**
     * Lists all User models.
     *
     * @return string
     */
    public function actionIndex()
    {
        if (!Yii::$app->user->can('accessBackOffice')) {
            throw new \yii\web\ForbiddenHttpException('Não tem permissão para aceder a esta página.');
        }

        $users = User::find()->all();

        return $this->render('index', [
            'users' => $users,
        ]);
    }

    /**
     * Displays a single User model.
     * @param int $id
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        if (!Yii::$app->user->can('accessBackOffice')) {
            throw new \yii\web\ForbiddenHttpException('Não tem permissão para aceder a esta página.');
        }

        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        if (!Yii::$app->user->can('addUsers')) {
            throw new \yii\web\ForbiddenHttpException('Não tem permissão para aceder a esta página.');
        }

        $model = new User();

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
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        if (!Yii::$app->user->can('editUsers')) {
            throw new \yii\web\ForbiddenHttpException('Não tem permissão para editar um utilizador.');
        }

        $model = $this->findModel($id);
        $isAdmin = Yii::$app->authManager->getAssignment('admin', $model->id);

        if (!$isAdmin) {
            $profile = $model->profile;

            if ($this->request->isPost && $model->load($this->request->post()) && $profile->load($this->request->post()) && $model->save() && $profile->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }

            return $this->render('update', [
                'model' => $model,
                'profile' => $profile,
            ]);
        } else {
            if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }

            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }



    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        if (!Yii::$app->user->can('deleteUsers')) {
            throw new \yii\web\ForbiddenHttpException('Não tem permissão para eliminar um user.');
        }

        $user = $this->findModel($id);

        if ($user) {
            Profile::deleteAll(['id_user' => $user->id]);
            $user->delete();
        }

        return $this->redirect(['index']);
    }


    public function actionPromote($id)
    {
        $auth = Yii::$app->authManager;
        $adminRole = $auth->getRole('admin');

        $auth->revokeAll($id);

        if ($auth->assign($adminRole, $id)) {
            Yii::$app->session->setFlash('success', 'Utilizador promovido a administrador com sucesso.');
        } else {
            Yii::$app->session->setFlash('error', 'Falha ao promover o utilizador.');
        }

        return $this->redirect(['view', 'id' => $id]);
    }

    public function actionDemote($id)
    {
        $auth = Yii::$app->authManager;
        $userRole = $auth->getRole('utilizador');
        $adminRole = $auth->getRole('admin');

        if ($adminRole) {
            if (Yii::$app->user->id == $id) {
                Yii::$app->session->setFlash('error', 'Falha ao despromover o administrador.');
                return $this->redirect(['view', 'id' => $id]);
            } else {
                if ($auth->revoke($adminRole, $id)) {
                    $auth->assign($userRole, $id);
                    Yii::$app->session->setFlash('error', 'Admin despromovido');
                }
            }
        }
        return $this->redirect(['view', 'id' => $id]);
    }


    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
