<?php

namespace app\models\seceon;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\seceon\SeceonSystemAlertModel;

/**
 * SeceonSystemAlertSearch represents the model behind the search form of `app\models\seceon\SeceonSystemAlertModel`.
 */
class SeceonSystemAlertSearch extends SeceonSystemAlertModel
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['system_event_severity', 'system_event_id', 'system_event_type_id', 'system_event_type', 'message', 'object', 'alert_id', 'alert_status', 'alert_type', 'alert_type_id', 'create_time', 'update_time', 'severity', 'tenant_id'], 'safe'],
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
        $query = SeceonSystemAlertModel::find();

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

        $query->andFilterWhere(['like', 'system_event_severity', $this->system_event_severity])
            ->andFilterWhere(['like', 'system_event_id', $this->system_event_id])
            ->andFilterWhere(['like', 'system_event_type_id', $this->system_event_type_id])
            ->andFilterWhere(['like', 'system_event_type', $this->system_event_type])
            ->andFilterWhere(['like', 'message', $this->message])
            ->andFilterWhere(['like', 'object', $this->object])
            ->andFilterWhere(['like', 'alert_id', $this->alert_id])
            ->andFilterWhere(['like', 'alert_status', $this->alert_status])
            ->andFilterWhere(['like', 'alert_type', $this->alert_type])
            ->andFilterWhere(['like', 'alert_type_id', $this->alert_type_id])
            ->andFilterWhere(['like', 'create_time', $this->create_time])
            ->andFilterWhere(['like', 'update_time', $this->update_time])
            ->andFilterWhere(['like', 'severity', $this->severity])
            ->andFilterWhere(['like', 'tenant_id', $this->tenant_id]);

        return $dataProvider;
    }

    public function displayColumns(){
        return [
            ['class' => 'yii\grid\SerialColumn'],
            'system_event_severity:text:Event Severity',
            'system_event_id:text:System Event',
            'system_event_type_id:text: Event Type ID',
            'system_event_type:text:Event Type',
            'alert_id:text:Alert ID',
            'alert_status:text:Alert Status',
            'alert_type_id:text:Alert Type ID',
            'alert_type:text: Alert Type',
           'create_time:text:Create Time',
           'update_time:text:Update Time',
           'severity:text:Severity'
        ];
    }
}
