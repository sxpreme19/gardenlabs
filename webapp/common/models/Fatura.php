<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "fatura".
 *
 * @property int $id
 * @property float $total
 * @property string $datahora
 * @property string $nome_destinatario
 * @property string $morada_destinatario
 * @property int|null $telefone_destinatario
 * @property int|null $nif_destinatario
 * @property float $preco_envio
 * @property int $metodopagamento_id
 * @property int $metodoexpedicao_id
 * @property int $userprofile_id
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
            [['total', 'datahora', 'nome_destinatario', 'morada_destinatario', 'preco_envio', 'metodopagamento_id', 'metodoexpedicao_id', 'userprofile_id'], 'required'],
            [['total', 'preco_envio'], 'number'],
            [['datahora'], 'safe'],
            [['telefone_destinatario', 'nif_destinatario', 'metodopagamento_id', 'metodoexpedicao_id', 'userprofile_id'], 'integer'],
            [['nome_destinatario', 'morada_destinatario'], 'string', 'max' => 80],
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
            'nome_destinatario' => 'Nome Destinatario',
            'morada_destinatario' => 'Morada Destinatario',
            'telefone_destinatario' => 'Telefone Destinatario',
            'nif_destinatario' => 'Nif Destinatario',
            'preco_envio' => 'Preco Envio',
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

    /**
     * Gets query for [[Metodoexpedicao]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMetodoexpedicao()
    {
        return $this->hasOne(Metodoexpedicao::class, ['id' => 'metodoexpedicao_id']);
    }

    /**
     * Gets query for [[Metodopagamento]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMetodopagamento()
    {
        return $this->hasOne(Metodopagamento::class, ['id' => 'metodopagamento_id']);
    }
    
    public function calculateTotal()
    {
        $total = 0;
        foreach ($this->linhafaturas as $linha) {
            $total += $linha->precounitario * $linha->quantidade;
        }
        $this->total = $total;
        $this->save();
    }
}
