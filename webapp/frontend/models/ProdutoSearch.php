<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Produto;

/**
 * ProdutoSearch represents the model behind the search form of `common\models\Produto`.
 */
class ProdutoSearch extends Produto
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'quantidade', 'categoria_id', 'fornecedor_id'], 'integer'],
            [['descricao', 'nome'], 'safe'],
            [['preco'], 'number'],
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
        $query = Produto::find()->joinWith('imagems')->where(['not', ['imagem.id' => null]]);

        if (!empty($params['sort'])) {
            switch ($params['sort']) {
                case '1':
                    $query->orderBy(['preco' => SORT_DESC]);
                    break;
                case '2':
                    $query->orderBy(['preco' => SORT_ASC]);
                    break;
                case '3':
                    $query->joinWith('linhafaturas')
                      ->select([
                          'produto.*',
                          'COALESCE(COUNT(linhafatura.id), 0) AS sales_count'
                      ])
                      ->orderBy(['sales_count' => SORT_DESC]);
                    break;
                default:
                    $query->orderBy(['nome' => SORT_ASC]);
                    break;
            }
        }

        if (!empty($params['categoria_id'])) {
            $query->andWhere(['categoria_id' => $params['categoria_id']]);
        }

        if (!empty($params['minPrice']) && !empty($params['maxPrice'])) {
            $minPrice = $params['minPrice'];
            $maxPrice = $params['maxPrice'];
            $query->andWhere(['between', 'preco', $minPrice, $maxPrice]);
        }

        if (!empty($params['search'])) {
            $search = $params['search'];
            $query->andWhere(['like', 'nome', $search]);
        }

        $query->groupBy(['produto.id']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 12,
            ],
        ]);

        $this->load($params);

        return $dataProvider;
    }
}
