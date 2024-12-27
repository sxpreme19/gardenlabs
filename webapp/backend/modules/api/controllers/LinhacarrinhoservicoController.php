<?php

namespace backend\modules\api\controllers;

use common\models\User;
use yii\filters\auth\HttpBasicAuth;
use yii\rest\ActiveController;
use yii\web\ForbiddenHttpException;

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
            'class' => HttpBasicAuth::class,
            'auth' => [$this,'auth']
        ];
        $behaviors['access'] = [
            'class' => \yii\filters\AccessControl::class,
            'rules' => [
                [
                    'allow' => true,
                    'roles' => ['@'], 
                ],
            ],
        ];
        
        return $behaviors;
    }

    public function auth($username,$password){
        $user = User::findByUsername($username);
        if($user && $user->validatePassword($password)){
            return $user;
        }
        throw new ForbiddenHttpException('No authentication');
    }
}