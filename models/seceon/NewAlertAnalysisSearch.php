<?php

namespace app\models\seceon;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\seceon\NewAlertAnalysisModel;

/**
 * NewAlertAnalysisSearch represents the model behind the search form of `app\models\seceon\NewAlertAnalysisModel`.
 */
class NewAlertAnalysisSearch extends NewAlertAnalysisModel
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['tenant_id', 'user_name', 'alert_severity', 'alert_severity_score', 'rpca_updated', 'alert_type', 'source_data_type_list', 'update_time', 'object_network_name', 'alert_id', 'situation_name', 'severity', 'alert_type_id', 'create_time', 'mitre_tid_list', 'message', 'object_id', 'event_origin_list', 'alert_status', 'prev_situation_id', 'is_uda', 'tm_id', 'alert_score', 'prev_alert_status', 'situation_id', 'recent_event_timestamp', 'is_severity_changed', 'entity', 'full_name'], 'safe'],
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
        $query = NewAlertAnalysisModel::find();

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

        $query->andFilterWhere(['like', 'tenant_id', $this->tenant_id])
            ->andFilterWhere(['like', 'user_name', $this->user_name])
            ->andFilterWhere(['like', 'alert_severity', $this->alert_severity])
            ->andFilterWhere(['like', 'alert_severity_score', $this->alert_severity_score])
            ->andFilterWhere(['like', 'rpca_updated', $this->rpca_updated])
            ->andFilterWhere(['like', 'alert_type', $this->alert_type])
            ->andFilterWhere(['like', 'source_data_type_list', $this->source_data_type_list])
            ->andFilterWhere(['like', 'update_time', $this->update_time])
            ->andFilterWhere(['like', 'object_network_name', $this->object_network_name])
            ->andFilterWhere(['like', 'alert_id', $this->alert_id])
            ->andFilterWhere(['like', 'situation_name', $this->situation_name])
            ->andFilterWhere(['like', 'severity', $this->severity])
            ->andFilterWhere(['like', 'alert_type_id', $this->alert_type_id])
            ->andFilterWhere(['like', 'create_time', $this->create_time])
            ->andFilterWhere(['like', 'mitre_tid_list', $this->mitre_tid_list])
            ->andFilterWhere(['like', 'message', $this->message])
            ->andFilterWhere(['like', 'object_id', $this->object_id])
            ->andFilterWhere(['like', 'event_origin_list', $this->event_origin_list])
            ->andFilterWhere(['like', 'alert_status', $this->alert_status])
            ->andFilterWhere(['like', 'prev_situation_id', $this->prev_situation_id])
            ->andFilterWhere(['like', 'is_uda', $this->is_uda])
            ->andFilterWhere(['like', 'tm_id', $this->tm_id])
            ->andFilterWhere(['like', 'alert_score', $this->alert_score])
            ->andFilterWhere(['like', 'prev_alert_status', $this->prev_alert_status])
            ->andFilterWhere(['like', 'situation_id', $this->situation_id])
            ->andFilterWhere(['like', 'recent_event_timestamp', $this->recent_event_timestamp])
            ->andFilterWhere(['like', 'is_severity_changed', $this->is_severity_changed])
            ->andFilterWhere(['like', 'entity', $this->entity])
            ->andFilterWhere(['like', 'full_name', $this->full_name]);

        return $dataProvider;
    }

    public function displayColumns()
    {
        return [
            ['class' => 'yii\grid\SerialColumn'],
            'user_name:text:Username',
            'alert_severity:text: Severity',
            'alert_severity_score:text:Severity Score',
            'rpca_updated:text:RPCA',
            'alert_type:text: Alert Type',
            //'alert_id:text:',
            'object_network_name:text:Network name',
            'situation_name:text:Situation Name',
        ];
    }
}
