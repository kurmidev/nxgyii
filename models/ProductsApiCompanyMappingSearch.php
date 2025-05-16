<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ProductsApiCompanyMapping;

/**
 * ProductsApiCompanyMappingSearch represents the model behind the search form of `app\models\ProductsApiCompanyMapping`.
 */
class ProductsApiCompanyMappingSearch extends ProductsApiCompanyMapping
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'product_id', 'company_id', 'api_id', 'display_type', 'on_main_dashboard', 'status', 'added_by', 'updated_by'], 'integer'],
            [['report_name', 'filters', 'display_columns', 'added_on', 'updated_on'], 'safe'],
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
        $query = ProductsApiCompanyMapping::find();

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
            'company_id' => $this->company_id,
            'api_id' => $this->api_id,
            'display_type' => $this->display_type,
            'on_main_dashboard' => $this->on_main_dashboard,
            'status' => $this->status,
            'added_on' => $this->added_on,
            'updated_on' => $this->updated_on,
            'added_by' => $this->added_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'report_name', $this->report_name])
            ->andFilterWhere(['like', 'filters', $this->filters])
            ->andFilterWhere(['like', 'display_columns', $this->display_columns]);

        return $dataProvider;
    }
}
