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
            'except' => ['register', 'login', 'reset-password'],
        ];
        return $behaviors;
    }

    public function actionRegister()
    {

        $username = Yii::$app->request->post('username');
        $password = Yii::$app->request->post('password');
        $email = Yii::$app->request->post('email');

        $model = new User();
        $model->username = $username;
        $model->email = $email;
        $model->setPassword($password);
        $model->status = 10;
        $model->generateAuthKey();
        $model->generateEmailVerificationToken();

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

    public function actionLogin()
    {

        $username = Yii::$app->request->post('username');
        $password = Yii::$app->request->post('password');

        $user = User::findOne(['username' => $username]);
        $userProfile = $user->userProfile;
        $userServiceCart = $userProfile->carrinhoservico;

        if ($user && $user->validatePassword($password)) {
            if (Yii::$app->authManager->checkAccess($user->id, 'client')) {
                if (empty($user->auth_key)) {
                    $user->generateAuthKey();
                }

                return [
                    'token' => $user->auth_key,
                    'id' => $user->id,
                    'profileid' => $userProfile->id,
                    'servicecartid' => $userServiceCart->id,
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
            'errors' => $user->errors,
        ];
    }

    public function actionResetPassword()
    {
        $email = Yii::$app->request->post('email');
        $oldPassword = Yii::$app->request->post('oldpassword');
        $newPassword = Yii::$app->request->post('newpassword');

        $user = User::findOne(['email' => $email]);

        if (!$user || !$user->validatePassword($oldPassword)) {
            return [
                'message' => 'Reset password failed.',
                'errors' => 'Invalid username or old password.',
            ];
        }

        $user->setPassword($newPassword);
        $user->generateAuthKey();

        if ($user->save()) {
            return [
                'message' => 'Password reset successfully.',
            ];
        }

        return [
            'message' => 'Password reset failed.',
            'errors' => $user->errors,
        ];
    }

    public function delete()
{
    $transaction = Yii::$app->db->beginTransaction();
    try {
        // Custom deletion logic
        $userProfile = $this->userProfile;
        if ($userProfile) {
            $userProfile->delete();
        }

        // Perform other deletions or actions as needed

        // Delete the user
        parent::delete();

        // Commit transaction
        $transaction->commit();
        return true;
    } catch (\Exception $e) {
        // Rollback transaction in case of error
        $transaction->rollBack();
        throw $e;
    }
}

}
