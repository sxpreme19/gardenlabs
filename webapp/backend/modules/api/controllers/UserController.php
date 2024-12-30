<?php

namespace backend\modules\api\controllers;

use yii\rest\ActiveController;
use Yii;
use yii\filters\auth\QueryParamAuth;
use common\models\User;
use common\models\Userprofile;
use common\models\Carrinhoproduto;
use common\models\Carrinhoservico;

class UserController extends ActiveController
{
    public $modelClass = 'common\models\User';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => QueryParamAuth::className(),
            'except' => ['register', 'login'],
        ];
        return $behaviors;
    }

    public function actionRegister($username, $password, $email)
    {
        $model = new $this->modelClass();
        $model->username = $username;
        $model->email = $email;
        $model->setPassword($password);
        $model->status = 10;
        $model->generateAuthKey();

        if ($model->save()) {
            $auth = Yii::$app->authManager;
            $clientRole = $auth->getRole('client');
            $auth->assign($clientRole, $model->id);

            $userprofile = new UserProfile();
            $userprofile->user_id = $model->id;

            if ($userprofile->save()) {
                $userProductCart = new Carrinhoproduto();
                $userProductCart->userprofile_id = $userprofile->id;
                if ($userProductCart->save()) {
                    $userServiceCart = new Carrinhoservico();
                    $userServiceCart->userprofile_id = $userprofile->id;
                    if ($userServiceCart->save()) {
                        return [
                            'message' => 'User registered successfully.',
                            'user' => $model,
                        ];
                    }
                }
            }

            $model->delete();
        }

        return [
            'message' => 'Registration failed.',
            'errors' => $model->errors,
        ];
    }

    public function actionLogin($username, $password)
    {
        $user = User::findOne(['username' => $username]);

        if ($user && $user->validatePassword($password)) {
            if (Yii::$app->authManager->checkAccess($user->id, 'client')) {
                if (empty($user->auth_key)) {
                    $user->generateAuthKey();
                }

                return [
                    'access_token' => $user->auth_key,
                    'user' => [
                        'id' => $user->id,
                        'username' => $user->username,
                    ],
                ];
            } else {
                return [
                    'message' => 'Access denied.',
                    'errors' => 'User does not have the required role.',
                ];
            }
        }

        return [
            'message' => 'Login failed.',
            'errors' => 'Invalid username or password.',
        ];
    }
}
