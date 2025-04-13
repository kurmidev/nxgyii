<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "categories".
 *
 * @property int $id
 * @property string $name
 * @property int $parent_id
 * @property int $type
 * @property string|null $description
 * @property int $status
 * @property int $created_by
 * @property int $updated_by
 * @property int $created_at
 * @property int $updated_at
 */
class Categories extends \app\models\BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'categories';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'type','status'], 'required'],
            [['parent_id', 'type', 'status',  'added_on', 'updated_on', 'added_by', 'updated_by'], 'integer'],
            [['description'], 'string'],
            [['name'], 'string', 'max' => 100],
            [['name'], 'unique'],
        ];
    }

    public function scenarios()
    {
        return [
            self::SCENARIO_DEFAULT => ['name', 'parent_id', 'type', 'description', 'status',  'added_on', 'updated_on', 'added_by', 'updated_by'],
            self::SCENARIO_CREATE => ['name', 'parent_id', 'type', 'description', 'status',  'added_on', 'updated_on', 'added_by', 'updated_by'],
            self::SCENARIO_UPDATE => ['name', 'parent_id', 'type', 'description', 'status', 'updated_by', 'updated_at'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'parent_id' => 'Parent ID',
            'type' => 'Type',
            'description' => 'Description',
            'status' => 'Status',
            'added_on' => 'Added On',
            'updated_on' => 'Updated On',
            'added_by' => 'Added By',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * {@inheritdoc}
     * @return CategoriesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CategoriesQuery(get_called_class());
    }

    public function getParent(){
        return $this->hasOne(Categories::class, ['id' => 'parent_id']);
    }
}
