<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;
use common\models\Userprofile;

/**
 * Signup form
 */
class UpdateUserForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $nif;
    public $nome;
    public $morada;
    public $telefone;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            [
                'username', 
                'unique', 
                'targetClass' => '\common\models\User', 
                'filter' => function ($query) {
                    // Exclude the current user's ID to avoid conflicts during updates
                    $query->andWhere(['not', ['id' => Yii::$app->user->id]]);
                }, 
                'message' => 'This username has already been taken.',
            ],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            [
                'email', 
                'unique', 
                'targetClass' => '\common\models\User', 
                'filter' => function ($query) {
                    $query->andWhere(['not', ['id' => Yii::$app->user->id]]);
                }, 
                'message' => 'This email address has already been taken.',
            ],

            //['password', 'required'],
            ['password', 'string', 'min' => Yii::$app->params['user.passwordMinLength']],
            [['nif', 'telefone'], 'integer'],
            [['morada', 'nome'], 'string', 'max' => 80],
        ];
    }

    /**
     * Updates user up.
     *
     * @return bool whether the creating new account was successful and email was sent
     */
    public function update()
    {
        if (!$this->validate()) {
            return null;
        }

        $user = User::findOne(Yii::$app->user->id); 
        if (!$user) {
            return false;
        }

        $user->username = $this->username;
        $user->email = $this->email;

        if ($this->password) {
            $user->setPassword($this->password);
            $user->generateAuthKey();
        }

        if ($user->save()) {
            $userProfile = UserProfile::findOne(['user_id' => Yii::$app->user->id]);
            if (!$userProfile) {
                $userProfile = new UserProfile();
                $userProfile->user_id = Yii::$app->user->id; 
            }
            $userProfile->nome = $this->nome;
            $userProfile->telefone = $this->telefone;
            $userProfile->nif = $this->nif;
            $userProfile->morada = $this->morada;
            if ($userProfile->save()) {
                return true;
            }
        }

        return null;
    }

}
