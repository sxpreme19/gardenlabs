<?php

namespace backend\modules\api\controllers;

use common\models\Linhacarrinhoservico;
use yii\filters\auth\QueryParamAuth;
use yii\rest\ActiveController;

/**
 * Default controller for the `api` module
 */
class LinhacarrinhoservicoController extends ActiveController
{
    public $modelClass = 'common\models\Linhacarrinhoservico';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => QueryParamAuth::className(),
        ];
        return $behaviors;
    }

    public function actionGetbycarrinhoservicoid($id)
    {
        $serviceCartLines = Linhacarrinhoservico::find()
            ->where(['carrinhoservico_id' => $id])
            ->all();

        return $serviceCartLines;
    }
}