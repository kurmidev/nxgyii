<?php

namespace app\models\seceon;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "alert_analysis".
 *
 * @property string|null $tenant_id
 * @property string|null $alert_severity
 * @property string|null $alert_severity_score
 * @property string|null $rpca_updated
 * @property string|null $alert_type
 * @property string|null $source_data_type_list
 * @property string|null $update_time
 * @property string|null $object_network_name
 * @property string|null $alert_id
 * @property string|null $situation_name
 * @property string|null $severity
 * @property string|null $alert_type_id
 * @property string|null $create_time
 * @property string|null $mitre_tid_list
 * @property string|null $message
 * @property string|null $object_id
 * @property string|null $event_origin_list
 * @property string|null $alert_status
 * @property string|null $prev_situation_id
 * @property string|null $is_uda
 * @property string|null $tm_id
 * @property string|null $alert_score
 * @property string|null $prev_alert_status
 * @property string|null $situation_id
 * @property string|null $recent_event_timestamp
 * @property string|null $is_severity_changed
 * @property string|null $entity
 * @property string|null $user_name
 * @property string|null $full_name
 */
class AlertAnalysisModel extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'alert_analysis';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['source_data_type_list', 'mitre_tid_list', 'event_origin_list', 'entity'], 'safe'],
            [['tenant_id', 'alert_severity', 'alert_severity_score', 'rpca_updated', 'alert_type', 'update_time', 'object_network_name', 'alert_id', 'situation_name', 'severity', 'alert_type_id', 'create_time', 'message', 'object_id', 'alert_status', 'prev_situation_id', 'is_uda', 'tm_id', 'alert_score', 'prev_alert_status', 'situation_id', 'recent_event_timestamp', 'is_severity_changed', 'user_name', 'full_name'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'tenant_id' => 'Tenant ID',
            'alert_severity' => 'Alert Severity',
            'alert_severity_score' => 'Alert Severity Score',
            'rpca_updated' => 'Rpca Updated',
            'alert_type' => 'Alert Type',
            'source_data_type_list' => 'Source Data Type List',
            'update_time' => 'Update Time',
            'object_network_name' => 'Object Network Name',
            'alert_id' => 'Alert ID',
            'situation_name' => 'Situation Name',
            'severity' => 'Severity',
            'alert_type_id' => 'Alert Type ID',
            'create_time' => 'Create Time',
            'mitre_tid_list' => 'Mitre Tid List',
            'message' => 'Message',
            'object_id' => 'Object ID',
            'event_origin_list' => 'Event Origin List',
            'alert_status' => 'Alert Status',
            'prev_situation_id' => 'Prev Situation ID',
            'is_uda' => 'Is Uda',
            'tm_id' => 'Tm ID',
            'alert_score' => 'Alert Score',
            'prev_alert_status' => 'Prev Alert Status',
            'situation_id' => 'Situation ID',
            'recent_event_timestamp' => 'Recent Event Timestamp',
            'is_severity_changed' => 'Is Severity Changed',
            'entity' => 'Entity',
            'user_name' => 'User Name',
            'full_name' => 'Full Name',
        ];
    }

    /**
     * {@inheritdoc}
     * @return AlertAnalysisQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AlertAnalysisQuery(get_called_class());
    }
}

class AlertAnalysisQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return AlertAnalysisModel[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return AlertAnalysisModel|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
