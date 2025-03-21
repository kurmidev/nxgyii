<?php

namespace app\models\seceon;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "seceon_alert_data".
 *
 * @property int|null $critical
 * @property int|null $major
 * @property int|null $system
 */
class AlertDataModel extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'seceon_alert_data';
    }

    /**
     * {@inheritdoc} 
     */
    public function rules()
    {
        return [
            [['critical', 'major', 'system'], 'integer'],
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'critical' => 'Critical',
            'major' => 'Major',
            'system' => 'System',
        ];
    }

    /**
     * {@inheritdoc}
     * @return AlertDataQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AlertDataQuery(get_called_class());
    }
}


class AlertDataQuery extends ActiveQuery
{
    /*public function active()
{
    return $this->andWhere('[[status]]=1');
}*/

    /**
     * {@inheritdoc}
     * @return AlertDataModel[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return AlertDataModel|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

}