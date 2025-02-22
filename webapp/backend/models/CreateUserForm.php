<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use common\models\User;
use common\models\Userprofile;
use common\models\Carrinhoproduto;
use common\models\Carrinhoservico;

/**
 * CreateUserForm form
 */
class CreateUserForm extends Model
{
    public $username;
    public $email;
    public $password;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => Yii::$app->params['user.passwordMinLength']],
        ];
    }

    /**
     * Signs user up.
     *
     * 
     */
    public function create()
    {
        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->generateEmailVerificationToken();
        $user->status = 10;

        if ($user->save()) {
            $auth = Yii::$app->authManager;
            $roleName = Yii::$app->request->post('roleDropDown');
            $role = $auth->getRole($roleName);
            $auth->assign($role, $user->id);

            $userprofile = new UserProfile();
            $userprofile->user_id = $user->id;

            if ($userprofile->save()) {
                if ($roleName == 'client') {
                    $userProductCart = new Carrinhoproduto();
                    $userProductCart->userprofile_id = $userprofile->id;
                    if ($userProductCart->save()) {
                        $userServiceCart = new Carrinhoservico();
                        $userServiceCart->userprofile_id = $userprofile->id;
                        if ($userServiceCart->save()) {
                            return $user;
                        }
                    }
                }
                return $user;
            }

            $user->delete();
        }

        return null;
    }
}
