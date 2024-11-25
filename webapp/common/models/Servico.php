<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "servico".
 *
 * @property int $id
 * @property string $descricao
 * @property float $preco
 * @property string $titulo
 * @property int $duracao
 * @property int $prestador_id
 */
class Servico extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'servico';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['descricao', 'preco', 'titulo', 'duracao', 'prestador_id'], 'required'],
            [['preco'], 'number'],
            [['duracao', 'prestador_id'], 'integer'],
            [['descricao'], 'string', 'max' => 200],
            [['titulo'], 'string', 'max' => 45],
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
            'titulo' => 'Titulo',
            'duracao' => 'Duracao',
            'prestador_id' => 'Prestador ID',
        ];
    }
}
