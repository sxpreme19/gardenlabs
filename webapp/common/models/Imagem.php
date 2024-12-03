<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "imagem".
 *
 * @property int $id
 * @property string $filename
 * @property int $produto_id
 *
 * @property Produto $produto
 */
class Imagem extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'imagem';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'filename', 'produto_id'], 'required'],
            [['id', 'produto_id'], 'integer'],
            [['filename'], 'string', 'max' => 80],
            [['id'], 'unique'],
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
            'filename' => 'Filename',
            'produto_id' => 'Produto ID',
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
}
