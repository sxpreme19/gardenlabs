<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "carrinho".
 *
 * @property int $id
 * @property float $total
 * @property int $userprofile_id
 *
 * @property Linhacarrinho[] $linhacarrinhos
 */
class Carrinho extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'carrinho';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['userprofile_id'], 'required'],
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
     * Gets query for [[Linhacarrinhos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLinhacarrinhos()
    {
        return $this->hasMany(Linhacarrinho::class, ['carrinho_id' => 'id']);
    }
}
