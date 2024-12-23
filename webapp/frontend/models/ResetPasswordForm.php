<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;

class ResetPasswordForm extends Model
{
    public $email;
    public $password;
    public $confirmPassword;
    public $oldPassword;

    /**
     * @var \common\models\User
     */
    private $_user;

    /**
     * ResetPasswordForm constructor.
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['email', 'password', 'confirmPassword', 'oldPassword'], 'required'],
            ['email', 'email'],
            ['email', 'exist', 'targetClass' => '\common\models\User', 'message' => 'No user with that email found.'],
            ['password', 'string', 'min' => Yii::$app->params['user.passwordMinLength']],
            ['confirmPassword', 'compare', 'compareAttribute' => 'password', 'message' => 'Passwords do not match.'],
            ['oldPassword', 'validateOldPassword'],
        ];
    }

    /**
     * Custom validation for the old password.
     */
    public function validateOldPassword($attribute, $params, $validator)
    {
        $this->_user = User::findOne(['email' => $this->email]);
        if (!$this->_user || !$this->_user->validatePassword($this->oldPassword)) {
            $this->addError($attribute, 'Incorrect old password.');
        }
    }

    /**
     * Resets the password for the user.
     *
     * @return bool
     */
    public function resetPassword()
    {
        if ($this->_user) {
            $this->_user->setPassword($this->password);
            $this->_user->generateAuthKey();
            return $this->_user->save(false);
        }

        return false;
    }
}
