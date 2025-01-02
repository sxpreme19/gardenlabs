<?php

namespace backend\modules\api\controllers;

use yii\rest\ActiveController;
use yii\filters\auth\QueryParamAuth;
use common\models\Userprofile;

/**
 * Default controller for the `api` module
 */
class UserprofileController extends ActiveController
{
    public $modelClass = 'common\models\Userprofile';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => QueryParamAuth::className(),
        ];
        return $behaviors;
    }

    public function actionGetbyuserid($id){
        $userProfile = UserProfile::find()->where(['user_id' => $id])->one();
    
    if ($userProfile) {
        return $userProfile;
    } else {
        return ['error' => 'User profile not found.'];
    }
    }

}