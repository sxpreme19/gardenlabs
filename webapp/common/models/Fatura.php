<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "fatura".
 *
 * @property int $id
 * @property float $total
 * @property string $datahora
 * @property int $metodopagamento_id
 * @property int|null $metodoexpedicao_id
 * @property int $userprofile_id
 *
 * @property Linhafatura[] $linhafaturas
 */
class Fatura extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'fatura';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['total', 'datahora', 'metodopagamento_id', 'userprofile_id'], 'required'],
            [['total'], 'number'],
            [['datahora'], 'safe'],
            [['metodopagamento_id', 'metodoexpedicao_id', 'userprofile_id'], 'integer'],
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
            'datahora' => 'Datahora',
            'metodopagamento_id' => 'Metodopagamento ID',
            'metodoexpedicao_id' => 'Metodoexpedicao ID',
            'userprofile_id' => 'Userprofile ID',
        ];
    }

    /**
     * Gets query for [[Linhafaturas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLinhafaturas()
    {
        return $this->hasMany(Linhafatura::class, ['fatura_id' => 'id']);
    }
}
