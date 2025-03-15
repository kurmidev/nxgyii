<?php

namespace app\models\jumpcloud;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

class UpTimeModel extends ActiveRecord
{
    public static function tableName()
    {
        return 'jumpcloud_uptime';
    }

    public function attributes()
    {
        return ["days", "hours", "minutes", "seconds", "total_seconds", "system_id", "collection_time"];
    }

    public function rules()
    {
        return [
            [["days", "hours", "minutes", "seconds", "total_seconds", "system_id", "collection_time"], 'safe'],
        ];
    }

    public static function find()
    {
        return new UpTimeQuery(get_called_class());
    }
}


class UpTimeQuery extends ActiveQuery
{

}