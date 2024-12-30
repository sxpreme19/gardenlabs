<?php

namespace backend\modules\api\controllers;

use common\models\Servico;
use yii\filters\auth\QueryParamAuth;
use yii\rest\ActiveController;
use Yii;

/**
 * Default controller for the `api` module
 */
class ServicoController extends ActiveController
{
    public $modelClass = 'common\models\Servico';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => QueryParamAuth::className(),
        ];
        return $behaviors;
    }

    public function actionCount()
    {
        $servicosmodel = new $this->modelClass;
        $recs = $servicosmodel::find()->all();
        return ['count' => count($recs)];
    }
}