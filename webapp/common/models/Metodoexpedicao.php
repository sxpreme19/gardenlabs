<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "metodoexpedicao".
 *
 * @property int $id
 * @property string $descricao
 * @property float $preco
 * @property string $duracao
 */
class Metodoexpedicao extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'metodoexpedicao';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['descricao', 'preco', 'duracao'], 'required'],
            [['preco'], 'number'],
            [['descricao'], 'string', 'max' => 45],
            [['duracao'], 'string', 'max' => 60],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'descricao' => 'Descricao',
            'preco' => 'Preco',
            'duracao' => 'Duracao',
        ];
    }
}
