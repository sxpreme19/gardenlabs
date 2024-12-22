<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "review".
 *
 * @property int $id
 * @property string $conteudo
 * @property string $datahora
 * @property float $avaliacao
 * @property int|null $servico_id
 * @property int|null $produto_id
 * @property int $userprofile_id
 *
 * @property Produto $produto
 * @property Servico $servico
 * @property Userprofile $userprofile
 */
class Review extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'review';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['conteudo', 'datahora', 'avaliacao', 'userprofile_id'], 'required'],
            [['id', 'servico_id', 'produto_id', 'userprofile_id'], 'integer'],
            [['datahora'], 'safe'],
            [['avaliacao'], 'number'],
            [['conteudo'], 'string', 'max' => 100],
            [['id'], 'unique'],
            [['produto_id'], 'exist', 'skipOnError' => true, 'targetClass' => Produto::class, 'targetAttribute' => ['produto_id' => 'id']],
            [['servico_id'], 'exist', 'skipOnError' => true, 'targetClass' => Servico::class, 'targetAttribute' => ['servico_id' => 'id']],
            [['userprofile_id'], 'exist', 'skipOnError' => true, 'targetClass' => Userprofile::class, 'targetAttribute' => ['userprofile_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'conteudo' => 'Conteudo',
            'datahora' => 'Datahora',
            'avaliacao' => 'Avaliacao',
            'servico_id' => 'Servico ID',
            'produto_id' => 'Produto ID',
            'userprofile_id' => 'Userprofile ID',
        ];
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

    /**
     * Gets query for [[Servico]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getServico()
    {
        return $this->hasOne(Servico::class, ['id' => 'servico_id']);
    }

    /**
     * Gets query for [[Userprofile]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserprofile()
    {
        return $this->hasOne(Userprofile::class, ['id' => 'userprofile_id']);
    }
}
