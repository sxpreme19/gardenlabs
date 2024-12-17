<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Carrinhoservico;

/**
 * CarrinhoservicoSearch represents the model behind the search form of `common\models\Carrinhoservico`.
 */
class CarrinhoservicoSearch extends Carrinhoservico
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'userprofile_id'], 'integer'],
            [['total'], 'number'],
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
        $query = Carrinhoservico::find();

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
            'total' => $this->total,
            'userprofile_id' => $this->userprofile_id,
        ]);

        return $dataProvider;
    }
}
