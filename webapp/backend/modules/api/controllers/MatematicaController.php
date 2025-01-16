<?php

namespace backend\modules\api\controllers;

use Facebook\WebDriver\Remote\ShadowRoot;
use yii\filters\auth\QueryParamAuth;
use yii\rest\ActiveController;

class MatematicaController extends ActiveController
{
    public $modelClass = 'common\models\Produto';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => QueryParamAuth::className(),
            'except' => ['raizdois'],
        ];
        return $behaviors;
    }

    public function actionRaizdois(){

        $raizdois = 1.41; 
        $output = "['raizdois' => ".$raizdois."]";
        
        return [
            $output
        ];
    }
}