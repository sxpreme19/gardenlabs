<?php

namespace backend\models;

use yii\base\Model;
use common\models\User;

class UpdateUserForm extends Model
{
    public $id;
    public $username;
    public $email;
    public $status;
    public $new_password;
    public $confirm_password;

    private $_user;

    public function __construct(User $user, $config = [])
    {
        $this->_user = $user;

        $this->id = $user->id;
        $this->username = $user->username;
        $this->email = $user->email;
        $this->status = $user->status;

        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['username', 'email', 'status'], 'required'],
            ['email', 'email'],
            [['status'], 'integer'],
            [['new_password', 'confirm_password'], 'string', 'min' => 6],
            ['confirm_password', 'compare', 'compareAttribute' => 'new_password', 'message' => 'Passwords must match.'],
        ];
    }

    public function update()
    {
        if (!$this->validate()) {
            return false;
        }

        $this->_user->username = $this->username;
        $this->_user->email = $this->email;
        $this->_user->status = $this->status;
        
        if ($this->new_password) {
            $this->_user->password_hash = \Yii::$app->security->generatePasswordHash($this->new_password);
        }

        return $this->_user->save();
    }
}
