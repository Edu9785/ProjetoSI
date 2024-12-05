<?php

namespace backend\modules\api\controllers;

use yii\rest\ActiveController;
use common\models\Profile;

class ProfileController extends ActiveController
{
    public $modelClass = 'common\models\Profile';

}