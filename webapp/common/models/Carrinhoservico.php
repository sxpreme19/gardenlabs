<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "carrinhoservico".
 *
 * @property int $id
 * @property float $total
 * @property int $userprofile_id
 *
 * @property Linhacarrinhoservico[] $linhacarrinhoservicos
 */
class Carrinhoservico extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'carrinhoservico';
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
     * Gets query for [[Linhacarrinhoservicos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLinhacarrinhoservicos()
    {
        return $this->hasMany(Linhacarrinhoservico::class, ['carrinhoservico_id' => 'id']);
    }
}
