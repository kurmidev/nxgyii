<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ProductsApiList;

/**
 * ProductsApiListSearch represents the model behind the search form of `app\models\ProductsApiList`.
 */
class ProductsApiListSearch extends ProductsApiList
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'product_id', 'status', 'added_by', 'updated_by'], 'integer'],
            [['api_name', 'api_endpoint', 'api_method', 'api_params', 'api_headers', 'api_body', 'api_response', 'added_on', 'updated_on'], 'safe'],
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
        $query = ProductsApiList::find();

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
            'product_id' => $this->product_id,
            'status' => $this->status,
            'added_on' => $this->added_on,
            'updated_on' => $this->updated_on,
            'added_by' => $this->added_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'api_name', $this->api_name])
            ->andFilterWhere(['like', 'api_endpoint', $this->api_endpoint])
            ->andFilterWhere(['like', 'api_method', $this->api_method])
            ->andFilterWhere(['like', 'api_params', $this->api_params])
            ->andFilterWhere(['like', 'api_headers', $this->api_headers])
            ->andFilterWhere(['like', 'api_body', $this->api_body])
            ->andFilterWhere(['like', 'api_response', $this->api_response]);

        return $dataProvider;
    }
}
