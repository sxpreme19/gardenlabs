<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Linhafatura;

/**
 * LinhafaturaSearch represents the model behind the search form of `common\models\Linhafatura`.
 */
class LinhafaturaSearch extends Linhafatura
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'quantidade', 'fatura_id', 'produto_id', 'servico_id'], 'integer'],
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
        $query = Linhafatura::find();

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
            'fatura_id' => $this->fatura_id,
            'produto_id' => $this->produto_id,
            'servico_id' => $this->servico_id,
        ]);

        return $dataProvider;
    }
}
