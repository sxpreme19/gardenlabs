<?php

namespace backend\modules\api\controllers;

use common\models\User;
use yii\filters\auth\QueryParamAuth;
use yii\rest\ActiveController;
use yii\web\ForbiddenHttpException;

/**
 * Default controller for the `api` module
 */
class ReviewController extends ActiveController
{
    public $modelClass = 'common\models\Review';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => QueryParamAuth::className(),
        ];
        return $behaviors;
    }
}
