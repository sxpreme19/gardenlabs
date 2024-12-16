<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "carrinhoproduto".
 *
 * @property int $id
 * @property float $total
 * @property int $userprofile_id
 *
 * @property Linhacarrinhoproduto[] $linhacarrinhoprodutos
 */
class Carrinhoproduto extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'carrinhoproduto';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['total', 'userprofile_id'], 'required'],
            [['total'], 'number'],
            [['userprofile_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'total' => 'Total',
            'userprofile_id' => 'Userprofile ID',
        ];
    }

    /**
     * Gets query for [[Linhacarrinhoprodutos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLinhacarrinhoprodutos()
    {
        return $this->hasMany(Linhacarrinhoproduto::class, ['carrinhoproduto_id' => 'id']);
    }
}
