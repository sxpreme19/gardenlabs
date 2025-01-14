<?php

namespace backend\modules\api\controllers;

use yii\rest\ActiveController;
use common\models\Fatura;
use yii\filters\auth\QueryParamAuth;

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

    public function actionId($id)
    {
        $invoices = Fatura::findOne($id);

        return $invoices;
    }

    public function actionGetbyuserprofileid($id)
    {
        $invoices = Fatura::find()
            ->joinWith('linhafaturas')
            ->where(['linhafatura.produto_id' => null])
            ->andWhere(['userprofile_id' => $id])
            ->groupBy('fatura.id')
            ->all();

        return $invoices;
    }
}
