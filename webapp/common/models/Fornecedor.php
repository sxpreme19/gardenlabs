<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "fornecedor".
 *
 * @property int $id
 * @property string $nome
 * @property string $email
 * @property int $telefone
 * @property string $localizacao
 */
class Fornecedor extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'fornecedor';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nome', 'email', 'telefone', 'localizacao'], 'required'],
            [['telefone'], 'integer'],
            [['nome', 'email'], 'string', 'max' => 80],
            [['localizacao'], 'string', 'max' => 200],
            ['telefone', 'match', 'pattern' => '/^\d{9}$/', 'message' => 'Telefone must be exactly 9 digits.'],
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
            'email' => 'Email',
            'telefone' => 'Telefone',
            'localizacao' => 'Localizacao',
        ];
    }

    public function getProdutos()
    {
        return $this->hasMany(Produto::class, ['fornecedor_id' => 'id']);
    }
}
