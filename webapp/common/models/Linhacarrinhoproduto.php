<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "linhacarrinhoproduto".
 *
 * @property int $id
 * @property int $quantidade
 * @property float $precounitario
 * @property int $carrinhoproduto_id
 * @property int $produto_id
 *
 * @property Carrinhoproduto $carrinhoproduto
 * @property Produto $produto
 */
class Linhacarrinhoproduto extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'linhacarrinhoproduto';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['quantidade', 'precounitario', 'carrinhoproduto_id', 'produto_id'], 'required'],
            [['quantidade', 'carrinhoproduto_id', 'produto_id'], 'integer'],
            [['precounitario'], 'number'],
            [['carrinhoproduto_id'], 'exist', 'skipOnError' => true, 'targetClass' => Carrinhoproduto::class, 'targetAttribute' => ['carrinhoproduto_id' => 'id']],
            [['produto_id'], 'exist', 'skipOnError' => true, 'targetClass' => Produto::class, 'targetAttribute' => ['produto_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'quantidade' => 'Quantidade',
            'precounitario' => 'Precounitario',
            'carrinhoproduto_id' => 'Carrinhoproduto ID',
            'produto_id' => 'Produto ID',
        ];
    }

    /**
     * Gets query for [[Carrinhoproduto]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCarrinhoproduto()
    {
        return $this->hasOne(Carrinhoproduto::class, ['id' => 'carrinhoproduto_id']);
    }

    /**
     * Gets query for [[Produto]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProduto()
    {
        return $this->hasOne(Produto::class, ['id' => 'produto_id']);
    }
}
