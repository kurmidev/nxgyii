<?php

namespace app\models\seceon;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "seceon_tenant".
 *
 * @property string|null $tenant_id
 * @property string|null $tenant_name
 * @property string|null $EDR
 * @property string|null $openvas
 * @property string|null $lts
 * @property string|null $tenant_location
 */
class SeceonTenantModel extends ActiveRecord{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'seceon_tenant';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tenant_id', 'tenant_name',], 'string', 'max' => 255],
            [[ 'EDR', 'openvas', 'lts', 'tenant_location'],'safe']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'tenant_id' => 'Tenant ID',
            'tenant_name' => 'Tenant Name',
            'EDR' => 'Edr',
            'openvas' => 'Openvas',
            'lts' => 'Lts',
            'tenant_location' => 'Tenant Location',
        ];
    }

    /**
     * {@inheritdoc}
     * @return SeceonTenantQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeceonTenantQuery(get_called_class());
    }
}


class SeceonTenantQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return SeceonTenantModel[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return SeceonTenantModel|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}