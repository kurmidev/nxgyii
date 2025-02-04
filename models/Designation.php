<?php

namespace app\models;

use app\component\AuthUser;
use app\component\Constants;
use Yii;

/**
 * This is the model class for table "designation".
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property int|null $parent_id
 * @property int $status
 * @property string $added_on
 * @property string|null $updated_on
 * @property int|null $added_by
 * @property int|null $updated_by
 */
class Designation extends \app\models\BaseModel
{
    public $menu;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'designation';
    }


    public function scenarios()
    {
        return [
            self::SCENARIO_DEFAULT => ['name', 'code', 'parent_id', 'status', 'added_on', 'updated_on', 'added_by', 'updated_by','menu'],
            self::SCENARIO_CREATE => ['name', 'code', 'parent_id', 'status', 'updated_on', 'updated_by','menu'],
            self::SCENARIO_UPDATE => ['name', 'code', 'parent_id', 'status', 'updated_on', 'updated_by','menu'],
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name','status'], 'required'],
            [['parent_id', 'status', 'added_by', 'updated_by'], 'integer'],
            [['added_on', 'updated_on'], 'safe'],
            [['name', 'code'], 'string', 'max' => 255],
            [['name'], 'unique'],
            [['code'], 'unique'],
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
            'code' => 'Code',
            'parent_id' => 'Parent ID',
            'status' => 'Status',
            'added_on' => 'Added On',
            'updated_on' => 'Updated On',
            'added_by' => 'Added By',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * @inheritdoc
     * @return DesignationQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new DesignationQuery(get_called_class());
    }

     /**
     * @inheritdoc
     */
    public function beforeSave($insert) {
        if ($this->scenario == self::SCENARIO_CREATE) {
            $this->code = empty($this->code) ? $this->generateCode(Constants::PREFIX_DESIG) : $this->code;
        }
        return parent::beforeSave($insert);
    }

    /**
     * @inheritdoc
     */
    public function afterSave($insert, $changedAttributes) {
        if (!empty($this->menu)) {
            $this->saveMenuData();
        }
        parent::afterSave($insert, $changedAttributes);
    }

    public function beforeValidate() {
        return parent::beforeValidate();
    }
    public function getParent() {
        return $this->hasOne(self::class, ['id' => 'parent_id']);
    }

    public function saveMenuData() {
        if (!empty($this->menu)) {
            $menu = array_keys($this->menu);
            AuthUser::addDesignationAuthRule($this->code, $menu);
        }
    }

}
