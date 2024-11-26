<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "userprofile".
 *
 * @property int $id
 * @property string|null $morada
 * @property int|null $nif
 * @property int|null $telefone
 * @property string|null $nome
 * @property int $user_id
 *
 * @property User $user
 */
class Userprofile extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'userprofile';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nif', 'telefone', 'user_id'], 'integer'],
            [['user_id'], 'required'],
            [['morada', 'nome'], 'string', 'max' => 80],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'morada' => 'Morada',
            'nif' => 'Nif',
            'telefone' => 'Telefone',
            'nome' => 'Nome',
            'user_id' => 'User ID',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
