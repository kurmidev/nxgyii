<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product_user_mapping".
 *
 * @property int $id
 * @property int|null $product_id
 * @property int|null $user_id
 * @property int|null $user_type
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property int|null $created_by
 */
class ProductUserMapping extends \app\models\BaseModel
{

    const USER_TYPE_COMPANY = 1;
    const USER_TYPE_EMPLOYEE = 2;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product_user_mapping';
    }

    public function scenarios(){
        return [
            self::SCENARIO_DEFAULT => ['*'], // Also tried without this line
            self::SCENARIO_CREATE => ['product_id', 'user_id', 'user_type'],
            self::SCENARIO_CONSOLE => ['product_id', 'user_id', 'user_type'],
            self::SCENARIO_UPDATE => ['id', 'product_id', 'user_id', 'user_type'],
            self::SCENARIO_DELETE => ['id'], // Also tried without this line
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'user_id', 'user_type'], 'required'],
            [['product_id', 'user_id', 'user_type'], 'integer'],
            [['added_on', 'added_by','updated_on', 'updated_by'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Product ID',
            'user_id' => 'User ID',
            'user_type' => 'User Type',
            'added_on' => 'Added On',
            'updated_on' => 'Updated On',
            'added_by' => 'Added By',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * {@inheritdoc}
     * @return ProductUserMappingQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProductUserMappingQuery(get_called_class());
    }
}
