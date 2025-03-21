<?php

namespace app\models\seceon;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\seceon\SeceonEventDataModel;

/**
 * SeceonEventDataSearch represents the model behind the search form of `app\models\seceon\SeceonEventDataModel`.
 */
class SeceonEventDataSearch extends SeceonEventDataModel
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cce_host', 'cce_ip', 'device_type', 'cce_version', 'device_name', 'device_ip', 'last_seen', 'total_count', 'tenant_id', 'log_type'], 'safe'],
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
        $query = SeceonEventDataModel::find();

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
        $query->andFilterWhere(['like', 'cce_host', $this->cce_host])
            ->andFilterWhere(['like', 'cce_ip', $this->cce_ip])
            ->andFilterWhere(['like', 'device_type', $this->device_type])
            ->andFilterWhere(['like', 'cce_version', $this->cce_version])
            ->andFilterWhere(['like', 'device_name', $this->device_name])
            ->andFilterWhere(['like', 'device_ip', $this->device_ip])
            ->andFilterWhere(['like', 'last_seen', $this->last_seen])
            ->andFilterWhere(['like', 'total_count', $this->total_count])
            ->andFilterWhere(['like', 'tenant_id', $this->tenant_id])
            ->andFilterWhere(['like', 'log_type', $this->log_type]);

        return $dataProvider;
    }

    public function displayColumns()
    {
        return [
            ['class' => 'yii\grid\SerialColumn'],
            'cce_host:text:CCE Host',
            'cce_ip:text:CCE IP',
            'device_type:text:Device Type',
            'cce_version:text:CCE Version',
            'device_name:text:Device Name',
            'device_ip:text:Device IP',
            'last_seen:text:Last Seen',
            'total_count:text:Total Count',
            // 'tenant_id:text:Tenant ID',
            // 'log_type:text:Log Type'
        ];
    }

}
