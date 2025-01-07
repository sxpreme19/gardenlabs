<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "categoria".
 *
 * @property int $id
 * @property string $nome
 */
class Categoria extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'categoria';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nome'], 'required'],
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
        ];
    }

    public function getProdutos()
    {
        return $this->hasMany(Produto::class, ['categoria_id' => 'id']);
    }
}
