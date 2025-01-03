<?php

namespace backend\modules\api\controllers;

use yii\filters\auth\QueryParamAuth;
use yii\rest\ActiveController;
use common\models\Carrinhoservico;

/**
 * Default controller for the `api` module
 */
class CarrinhoservicoController extends ActiveController
{
    public $modelClass = 'common\models\Carrinhoservico';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => QueryParamAuth::className(),
        ];
        return $behaviors;
    }
}