<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Fatura;

/**
 * FaturaSearch represents the model behind the search form of `common\models\Fatura`.
 */
class FaturaSearch extends Fatura
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'telefone_destinatario', 'nif_destinatario', 'metodopagamento_id', 'metodoexpedicao_id', 'userprofile_id'], 'integer'],
            [['total'], 'number'],
            [['datahora', 'nome_destinatario', 'morada_destinatario'], 'safe'],
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
        $query = Fatura::find();

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
            'datahora' => $this->datahora,
            'telefone_destinatario' => $this->telefone_destinatario,
            'nif_destinatario' => $this->nif_destinatario,
            'metodopagamento_id' => $this->metodopagamento_id,
            'metodoexpedicao_id' => $this->metodoexpedicao_id,
            'userprofile_id' => $this->userprofile_id,
        ]);

        $query->andFilterWhere(['like', 'nome_destinatario', $this->nome_destinatario])
            ->andFilterWhere(['like', 'morada_destinatario', $this->morada_destinatario]);

        return $dataProvider;
    }
}
