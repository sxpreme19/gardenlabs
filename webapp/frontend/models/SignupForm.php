<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;
use common\models\Userprofile;
use common\models\Carrinhoproduto;
use common\models\Carrinhoservico;

/**
 * Signup form
 */
class SignupForm extends Model
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
     * @return bool whether the creating new account was successful and email was sent
     */
    public function signup()
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
            $clientRole = $auth->getRole('client');
            $auth->assign($clientRole, $user->id);

            $userprofile = new UserProfile();
            $userprofile->user_id = $user->id;

            if ($userprofile->save()) {
                $userProductCart = new Carrinhoproduto();
                $userProductCart->userprofile_id = $userprofile->id;
                var_dump($userProductCart);
                if ($userProductCart->save()) {
                    $userServiceCart = new Carrinhoservico();
                    $userServiceCart->userprofile_id = $userprofile->id;
                    if ($userServiceCart->save()) {
                        return $user;   
                    }
                }
            }

            $user->delete();
        }

        return null;
    }
}
