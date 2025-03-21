<?php

namespace app\models\seceon;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "seceon_event_data".
 *
 * @property string|null $cce_host
 * @property string|null $cce_ip
 * @property string|null $device_type
 * @property string|null $cce_version
 * @property string|null $device_name
 * @property string|null $device_ip
 * @property string|null $last_seen
 * @property string|null $total_count
 * @property string|null $tenant_id
 * @property string|null $log_type
 */
class SeceonEventDataModel extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'seceon_event_data';
    }

    public static function primaryKey()
    {
        return ["tenant_id"];
    }

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
    public function attributeLabels()
    {
        return [
            'cce_host' => 'Cce Host',
            'cce_ip' => 'Cce Ip',
            'device_type' => 'Device Type',
            'cce_version' => 'Cce Version',
            'device_name' => 'Device Name',
            'device_ip' => 'Device Ip',
            'last_seen' => 'Last Seen',
            'total_count' => 'Total Count',
            'tenant_id' => 'Tenant ID',
            'log_type' => 'Log Type',
        ];
    }

    /**
     * {@inheritdoc}
     * @return SeceonEventDataQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeceonEventDataQuery(get_called_class());
    }
}

class SeceonEventDataQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return SeceonEventDataModel[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return SeceonEventDataModel|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
