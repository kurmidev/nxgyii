<?php

namespace app\models\jumpcloud;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

class CatalogModel extends ActiveRecord
{
    public static function tableName()
    {
        return 'jumpcloud_catalog';
    }

    public function attributes()
    {
        return ["id", "operatingSystem", "name", "version", "build", "releaseTimestamp"];
    }

    public function rules()
    {
        return [
            [["id", "operatingSystem", "name", "version", "build", "releaseTimestamp"], 'safe'],
        ];
    }

    public static function find()
    {
        return new CatalogQuery(get_called_class());
    }
}


class CatalogQuery extends ActiveQuery
{

}