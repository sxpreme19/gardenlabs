<?php

namespace backend\modules\api\controllers;

use common\models\Linhafatura;
use yii\filters\auth\QueryParamAuth;
use yii\rest\ActiveController;

/**
 * Default controller for the `api` module
 */
class LinhafaturaController extends ActiveController
{
    public $modelClass = 'common\models\Linhafatura';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => QueryParamAuth::className(),
        ];
        return $behaviors;
    }

    public function actionGetbyfaturaid($id)
    {
        $invoiceLines = Linhafatura::find()
            ->where(['fatura_id' => $id])
            ->all();

        return $invoiceLines;
    }

}