<?php

namespace app\models\seceon;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\seceon\ThreatDataModel;

/**
 * ThreatDataModelSearch represents the model behind the search form of `app\models\seceon\ThreatDataModel`.
 */
class ThreatDataModelSearch extends ThreatDataModel
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['src_host_name', 'src_network_name', 'user_name', 'message', 'event_category', 'event_type_name', 'source_data_type', 'src_ip', 'event_origin', 'dst_host_name', 'event_id', 'additional_info', 'dest_ip', 'mitre_technique_id', 'timestamp', 'tenant_id'], 'safe'],
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
        $query = ThreatDataModel::find();

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
        ]);

        $query->andFilterWhere(['like', 'src_host_name', $this->src_host_name])
            ->andFilterWhere(['like', 'src_network_name', $this->src_network_name])
            ->andFilterWhere(['like', 'user_name', $this->user_name])
            ->andFilterWhere(['like', 'message', $this->message])
            ->andFilterWhere(['like', 'event_category', $this->event_category])
            ->andFilterWhere(['like', 'event_type_name', $this->event_type_name])
            ->andFilterWhere(['like', 'source_data_type', $this->source_data_type])
            ->andFilterWhere(['like', 'src_ip', $this->src_ip])
            ->andFilterWhere(['like', 'event_origin', $this->event_origin])
            ->andFilterWhere(['like', 'dst_host_name', $this->dst_host_name])
            ->andFilterWhere(['like', 'event_id', $this->event_id])
            ->andFilterWhere(['like', 'additional_info', $this->additional_info])
            ->andFilterWhere(['like', 'dest_ip', $this->dest_ip])
            ->andFilterWhere(['like', 'mitre_technique_id', $this->mitre_technique_id])
            ->andFilterWhere(['like', 'timestamp', $this->timestamp])
            ->andFilterWhere(['like', 'tenant_id', $this->tenant_id]);

        return $dataProvider;
    }

    public function displayColumns()
    {
        return [
            ['class' => 'yii\grid\SerialColumn'],
            'event_id:text:Event No',
            'src_host_name:text:SRC HOST',
            'dst_host_name:text:DST HOST',
            'user_name:text:User Name',
            'event_type_name:text:Event Type',
            'timestamp:datetime:Timestamp',
            'event_category:text:Event category',
            'source_data_type:text:Source Data Type',
            //'additional_info:text:Additional Info',
            'event_origin:text:Event Origin',
            'event_name:text:Event Name',
            'src_network_name:text:Source Network Name',
            'src_ip:text:Source IP Address',
            'dest_ip:text:Destination IP Address',
            // 'mitre_technique_id:text:Mitre Technique ID',
        ];
    }
}
