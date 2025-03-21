<?php

namespace app\models\seceon;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "seceon_system_alert".
 *
 * @property int $id
 * @property string|null $system_event_severity
 * @property string|null $system_event_id
 * @property string|null $system_event_type_id
 * @property string|null $system_event_type
 * @property string|null $message
 * @property string|null $object
 * @property string|null $alert_id
 * @property string|null $alert_status
 * @property string|null $alert_type
 * @property string|null $alert_type_id
 * @property string|null $create_time
 * @property string|null $update_time
 * @property string|null $severity
 * @property string|null $tenant_id
 */
class SeceonSystemAlertModel extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'seceon_system_alert';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['object'], 'safe'],
            [['system_event_severity', 'system_event_id', 'system_event_type_id', 'system_event_type', 'message', 'alert_id', 'alert_status', 'alert_type', 'alert_type_id', 'create_time', 'update_time', 'severity', 'tenant_id'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'system_event_severity' => 'System Event Severity',
            'system_event_id' => 'System Event ID',
            'system_event_type_id' => 'System Event Type ID',
            'system_event_type' => 'System Event Type',
            'message' => 'Message',
            'object' => 'Object',
            'alert_id' => 'Alert ID',
            'alert_status' => 'Alert Status',
            'alert_type' => 'Alert Type',
            'alert_type_id' => 'Alert Type ID',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'severity' => 'Severity',
            'tenant_id' => 'Tenant ID',
        ];
    }

    /**
     * {@inheritdoc}
     * @return SeceonSystemAlertQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeceonSystemAlertQuery(get_called_class());
    }
}

class SeceonSystemAlertQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return SeceonSystemAlertModel[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return SeceonSystemAlertModel|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}