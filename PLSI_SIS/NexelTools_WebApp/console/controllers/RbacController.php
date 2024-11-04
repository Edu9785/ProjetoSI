<?php
namespace console\controllers;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;
        $auth->removeAll();

        $admin = $auth->createRole('admin');
        $auth->add($admin);

        $utilizador = $auth->createRole('utilizador');
        $auth->add($utilizador);



    }
}
