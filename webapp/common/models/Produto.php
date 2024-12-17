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
 * @property int $fornecedor_id
 * @property int $categoria_id
 *
 * @property Imagem[] $imagems
 * @property Linhacarrinhoproduto[] $linhacarrinhoprodutos
 * @property Linhafatura[] $linhafaturas
 * @property Review[] $reviews
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
            [['descricao', 'preco', 'nome', 'quantidade', 'fornecedor_id', 'categoria_id'], 'required'],
            [['preco'], 'number'],
            [['quantidade', 'fornecedor_id', 'categoria_id'], 'integer'],
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
            'fornecedor_id' => 'Fornecedor ID',
            'categoria_id' => 'Categoria ID',
        ];
    }

    /**
     * Gets query for Categoria.
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategoria()
    {
        return $this->hasOne(Categoria::class, ['id' => 'categoria_id']);
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
     * Gets query for [[Linhacarrinhoprodutos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLinhacarrinhoprodutos()
    {
        return $this->hasMany(Linhacarrinhoproduto::class, ['produto_id' => 'id']);
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

    /**
     * Gets query for [[Reviews]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReviews()
    {
        return $this->hasMany(Review::class, ['produto_id' => 'id']);
    }
}
