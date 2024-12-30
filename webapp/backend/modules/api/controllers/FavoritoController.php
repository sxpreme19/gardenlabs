<?php

namespace backend\modules\api\controllers;

use yii\rest\ActiveController;
use Yii;
use yii\filters\auth\QueryParamAuth;

class FavoritoController extends ActiveController
{
    public $modelClass = 'common\models\Favorito';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => QueryParamAuth::className(),
        ];
        return $behaviors;
    }
}
