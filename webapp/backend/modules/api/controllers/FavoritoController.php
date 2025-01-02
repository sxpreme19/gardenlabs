<?php

namespace backend\modules\api\controllers;

use yii\rest\ActiveController;
use common\models\Favorito;
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

    public function actionGetbyuserprofileid($id)
    {
        $favorites = Favorito::find()
            ->where(['userprofile_id' => $id])
            ->andWhere(['IS NOT', 'servico_id', null]) 
            ->all();

        return $favorites;
    }
}
