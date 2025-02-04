<?php

namespace app\models;

use Yii;

/**
 * This is the model class for collection "user_access_right".
 *
 * @property int $id
 * @property mixed $role_name
 * @property mixed $items
 * @property mixed $added_on
 * @property mixed $updated_on
 * @property mixed $added_by
 * @property mixed $updated_by
 */
class UserAccessRight extends BaseModel {

    /**
     * {@inheritdoc}
     */
    public static function tableName(){
        return 'user_access_right';
    }

    public function scenarios() {
        return [
            self::SCENARIO_DEFAULT => ['*'], // Also tried without this line
            self::SCENARIO_CREATE => ['id', 'role_name', 'items'],
            self::SCENARIO_CONSOLE => ['id', 'role_name', 'items'],
            self::SCENARIO_UPDATE => ['id', 'role_name', 'items'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributes() {
        return [
            'id',
            'role_name',
            'items',
            'added_on',
            'updated_on',
            'added_by',
            'updated_by',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['role_name', 'items', 'added_on', 'updated_on', 'added_by', 'updated_by'], 'safe']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'role_name' => 'Role Name',
            'items' => 'Items',
            'added_on' => 'Added On',
            'updated_on' => 'Updated On',
            'added_by' => 'Added By',
            'updated_by' => 'Updated By',
        ];
    }

}
