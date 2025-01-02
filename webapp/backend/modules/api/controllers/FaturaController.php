<?php

namespace backend\modules\api\controllers;

use yii\rest\ActiveController;
use common\models\Fatura;
use yii\filters\auth\QueryParamAuth;

/**
 * Default controller for the `api` module
 */
class FaturaController extends ActiveController
{
    public $modelClass = 'common\models\Fatura';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => QueryParamAuth::className(),
        ];
        return $behaviors;
    }

    public function actionGetbyuserprofileid($id)
    {
        $invoices = Fatura::find()
            ->where(['userprofile_id' => $id])
            ->all();

        return $invoices;
    }
}