<?php

namespace backend\modules\api\controllers;

use common\models\Review;
use yii\filters\auth\QueryParamAuth;
use yii\rest\ActiveController;

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
        $reviews = Review::find()
            ->where(['servico_id' => $id])
            ->all();

        return $reviews;
    }
}
