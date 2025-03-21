<?php

namespace app\models\seceon;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "seceon_dashboard".
 *
 * @property string|null $tenant_id
 * @property string|null $max_eps
 * @property string|null $avg_eps
 * @property string|null $events
 * @property string|null $threats
 * @property string|null $critical
 * @property string|null $major
 * @property string|null $minor
 * @property string|null $closed
 * @property string|null $remediated
 * @property string|null $assigned
 * @property string|null $trend
 * @property string|null $system
 */
class DashboardModel extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'seceon_dashboard';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['trend', 'events','minor','system'], 'safe'],
            [['tenant_id'], 'string', 'max' => 255],
            [['max_eps', 'avg_eps', 'threats', 'critical', 'major',  'closed', 'remediated', 'assigned'],'integer']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'tenant_id' => 'Tenant ID',
            'max_eps' => 'Max Eps',
            'avg_eps' => 'Avg Eps',
            'events' => 'Events',
            'threats' => 'Threats',
            'critical' => 'Critical',
            'major' => 'Major',
            'minor' => 'Minor',
            'closed' => 'Closed',
            'remediated' => 'Remediated',
            'assigned' => 'Assigned',
            'trend' => 'Trend',
            'system' => 'System',
        ];
    }

    /**
     * {@inheritdoc}
     * @return SeceonDashboardQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeceonDashboardQuery(get_called_class());
    }
}


class SeceonDashboardQuery extends ActiveQuery
{

}