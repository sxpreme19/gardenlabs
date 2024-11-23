<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "produto".
 *
 * @property int $id
 * @property string $descricao
 * @property float $preco
 * @property string $nome
 * @property int $quantidade
 * @property int $categoria_id
 * @property int $fornecedor_id
 *
 * @property Imagem[] $imagems
 * @property Linhacarrinho[] $linhacarrinhos
 * @property Linhafatura[] $linhafaturas
 */
class Produto extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'produto';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['descricao', 'preco', 'nome', 'quantidade', 'categoria_id', 'fornecedor_id'], 'required'],
            [['preco'], 'number'],
            [['quantidade', 'categoria_id', 'fornecedor_id'], 'integer'],
            [['descricao'], 'string', 'max' => 200],
            [['nome'], 'string', 'max' => 80],
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
            'nome' => 'Nome',
            'quantidade' => 'Quantidade',
            'categoria_id' => 'Categoria ID',
            'fornecedor_id' => 'Fornecedor ID',
        ];
    }
    
    /**
     * Gets query for [[Imagems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getImagems()
    {
        return $this->hasMany(Imagem::class, ['produto_id' => 'id']);
    }

    /**
     * Gets query for [[Linhacarrinhos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLinhacarrinhos()
    {
        return $this->hasMany(Linhacarrinho::class, ['produto_id' => 'id']);
    }

    /**
     * Gets query for [[Linhafaturas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLinhafaturas()
    {
        return $this->hasMany(Linhafatura::class, ['produto_id' => 'id']);
    }
}
