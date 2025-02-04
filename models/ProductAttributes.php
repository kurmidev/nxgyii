<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product_attributes".
 *
 * @property int $id
 * @property int|null $product_id
 * @property string|null $attr_value
 * @property string|null $attr_type
 * @property string $added_on
 * @property string|null $updated_on
 * @property int|null $added_by
 * @property int|null $updated_by
 */
class ProductAttributes extends \app\models\BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product_attributes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'added_by', 'updated_by'], 'integer'],
            [['added_on', 'updated_on'], 'safe'],
            [['attr_value', 'attr_type'], 'string', 'max' => 255],
            [['product_id', 'attr_type'], 'unique', 'targetAttribute' => ['product_id', 'attr_type']],
        ];
    }

    public function scenarios(){
        return [
            self::SCENARIO_CREATE => ['product_id', 'attr_value', 'attr_type'],
            self::SCENARIO_UPDATE => ['product_id', 'attr_value', 'attr_type'],
            self::SCENARIO_DEFAULT => ['product_id', 'attr_value', 'attr_type'],  // Default scenario for search, view, update, create etc.  // If no scenario is set, default is SCENARIO_DEFAULT.  // For example, you may want to disable some attributes in the search form based on the current scenario.
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
            'attr_value' => 'Attr Value',
            'attr_type' => 'Attr Type',
            'added_on' => 'Added On',
            'updated_on' => 'Updated On',
            'added_by' => 'Added By',
            'updated_by' => 'Updated By',
        ];
    }

    /** 
     * {@inheritdoc} 
     * @return ProductAttributesQuery the active query used by this AR class. 
     */
    public static function find()
    {
        return new ProductAttributesQuery(get_called_class());
    }
}
