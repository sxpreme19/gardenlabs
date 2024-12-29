<?php

namespace backend\modules\api\controllers;

use yii\rest\ActiveController;
use yii\web\Controller;
use yii\filters\auth\QueryParamAuth;

/**
 * Default controller for the `api` module
 */
class UserController extends ActiveController
{
    public $modelClass = 'common\models\User';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => QueryParamAuth::className(),
        ];
        return $behaviors;
    }
}
