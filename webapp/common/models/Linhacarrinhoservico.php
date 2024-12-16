<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "linhacarrinhoservico".
 *
 * @property int $id
 * @property float $preco
 * @property int $carrinhoservico_id
 * @property int $servico_id
 *
 * @property Carrinhoservico $carrinhoservico
 * @property Servico $servico
 */
class Linhacarrinhoservico extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'linhacarrinhoservico';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['preco', 'carrinhoservico_id', 'servico_id'], 'required'],
            [['preco'], 'number'],
            [['carrinhoservico_id', 'servico_id'], 'integer'],
            [['carrinhoservico_id'], 'exist', 'skipOnError' => true, 'targetClass' => Carrinhoservico::class, 'targetAttribute' => ['carrinhoservico_id' => 'id']],
            [['servico_id'], 'exist', 'skipOnError' => true, 'targetClass' => Servico::class, 'targetAttribute' => ['servico_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'preco' => 'Preco',
            'carrinhoservico_id' => 'Carrinhoservico ID',
            'servico_id' => 'Servico ID',
        ];
    }

    /**
     * Gets query for [[Carrinhoservico]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCarrinhoservico()
    {
        return $this->hasOne(Carrinhoservico::class, ['id' => 'carrinhoservico_id']);
    }

    /**
     * Gets query for [[Servico]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getServico()
    {
        return $this->hasOne(Servico::class, ['id' => 'servico_id']);
    }
}
