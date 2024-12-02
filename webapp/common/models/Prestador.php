<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "prestador".
 *
 * @property int $id
 * @property string $nome
 * @property int $telefone
 * @property int $user_id
 */
class Prestador extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'prestador';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nome', 'telefone', 'user_id'], 'required'],
            [['telefone', 'user_id'], 'integer'],
            [['nome'], 'string', 'max' => 80],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nome' => 'Nome',
            'telefone' => 'Telefone',
            'user_id' => 'User ID',
        ];
    }
}
