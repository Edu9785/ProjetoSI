<?php

namespace backend\controllers;

use common\models\Compra;
use common\models\Linhacompra;
use common\models\LoginForm;
use backend\models\SignupForm;
use common\models\Produto;
use common\models\User;
use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['login','signup', 'error'],
                        'allow' => true,
                        'roles' => ['?']
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $produtosvendidos = 0;
        $created_atFormatado = time()-86400;
        $ultimas24h = date('Y-m-d H:i:s', strtotime('-1 day'));
        $Usersrecentes = User::find()->where(['>=', 'created_at', $created_atFormatado])->count();
        $compras = Compra::find()->where(['>=', 'datacompra', $ultimas24h])->all();
        foreach ($compras as $compra){
            $produtosvendidos = $compra->getLinhacompras()->count();
        }

        $produtospublicados = Produto::find()->where(['>=', 'created_at', $ultimas24h])->count();

        return $this->render('index', [
            'usersRecentes' => $Usersrecentes,
            'produtosvendidos' => $produtosvendidos,
            'produtospublicados' => $produtospublicados,
        ]);
    }

    /**
     * Login action.
     *
     * @return string|Response
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {

            if(Yii::$app->user->can('accessBackOffice')){
                return $this->goHome();
            }
            Yii::$app->session->setFlash('error', "Login, permitido só a <strong>Administradores</strong>");
            return $this->goHome();
        }

        $this->layout = 'blank';

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {

            if (!Yii::$app->user->can('accessBackOffice')) {
                Yii::$app->user->logout();
                Yii::$app->session->setFlash('error', "Login permitido apenas para <strong>Administradores</strong>");
                return $this->goHome();
            }
            return $this->goBack();
        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionSignup()
    {
        $this->layout = 'blank';
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            return $this->redirect(['login']);
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }


    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
