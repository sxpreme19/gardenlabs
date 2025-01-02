<?php

namespace backend\modules\api\controllers;

use common\models\Servico;
use yii\filters\auth\QueryParamAuth;
use yii\rest\ActiveController;

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

    public function actionGetbyservicoid($id)
    {
        $reviews = Servico::find()
            ->where(['userprofile_id' => $id])
            ->all();

        return $reviews;
    }
}
