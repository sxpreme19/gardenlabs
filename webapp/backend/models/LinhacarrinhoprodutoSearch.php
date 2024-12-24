<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Linhacarrinhoproduto;

/**
 * LinhacarrinhoprodutoSearch represents the model behind the search form of `common\models\Linhacarrinhoproduto`.
 */
class LinhacarrinhoprodutoSearch extends Linhacarrinhoproduto
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'quantidade', 'carrinhoproduto_id', 'produto_id'], 'integer'],
            [['precounitario'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Linhacarrinhoproduto::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'quantidade' => $this->quantidade,
            'precounitario' => $this->precounitario,
            'carrinhoproduto_id' => $this->carrinhoproduto_id,
            'produto_id' => $this->produto_id,
        ]);

        return $dataProvider;
    }
}
