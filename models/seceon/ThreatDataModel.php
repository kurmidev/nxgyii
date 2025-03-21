<?php

namespace app\models\seceon;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "threat_data".
 *
 * @property int $id
 * @property string|null $src_host_name
 * @property string|null $src_network_name
 * @property string|null $user_name
 * @property string|null $message
 * @property string|null $event_category
 * @property string|null $event_type_name
 * @property string|null $source_data_type
 * @property string|null $src_ip
 * @property string|null $event_origin
 * @property string|null $dst_host_name
 * @property string|null $event_id
 * @property string|null $additional_info
 * @property string|null $dest_ip
 * @property string|null $mitre_technique_id
 * @property string|null $timestamp
 * @property string|null $tenant_id
 */
class ThreatDataModel extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'threat_data';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_name', 'message', 'event_category', 'event_type_name', 'source_data_type', 'src_ip', 'event_origin', 'dst_host_name', 'event_id', 'additional_info', 'mitre_technique_id'], 'safe'],
            [['src_host_name', 'src_network_name', 'dest_ip', 'timestamp', 'tenant_id'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'src_host_name' => 'Src Host Name',
            'src_network_name' => 'Src Network Name',
            'user_name' => 'User Name',
            'message' => 'Message',
            'event_category' => 'Event Category',
            'event_type_name' => 'Event Type Name',
            'source_data_type' => 'Source Data Type',
            'src_ip' => 'Src Ip',
            'event_origin' => 'Event Origin',
            'dst_host_name' => 'Dst Host Name',
            'event_id' => 'Event ID',
            'additional_info' => 'Additional Info',
            'dest_ip' => 'Dest Ip',
            'mitre_technique_id' => 'Mitre Technique ID',
            'timestamp' => 'Timestamp',
            'tenant_id' => 'Tenant ID',
        ];
    }

    /**
     * {@inheritdoc}
     * @return ThreatDataQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ThreatDataQuery(get_called_class());
    }
}


class ThreatDataQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ThreatDataModel[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ThreatDataModel|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
