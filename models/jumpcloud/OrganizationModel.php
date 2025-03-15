<?php

namespace app\models\jumpcloud;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

class OrganizationModel extends ActiveRecord
{
    public static function tableName()
    {
        return 'jumpcloud_organization';
    }
    public function rules()
    {
        return [
            [["id", "_id", "displayName", "logoUrl", "created"], 'safe']
        ];
    }
    public function attributes()
    {
        return ["id", "_id", "displayName", "logoUrl", "created"];
    }

    public static function find()
    {
        return new OrganizationQuery(get_called_class());
    }
}

class OrganizationQuery extends ActiveQuery{

}
