<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product_company_mapping".
 *
 * @property int $id
 * @property int $product_id
 * @property int $company_id
 * @property string|null $credentials
 * @property string|null $headers
 * @property int $status
 * @property string|null $added_on
 * @property string|null $updated_on
 * @property int|null $added_by
 * @property int|null $updated_by
 */
class ProductCompanyMapping extends \app\models\BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product_company_mapping';
    }

    public function scenarios()
    {
        return [
            self::SCENARIO_CREATE => ['product_id', 'company_id', 'credentials', 'status', 'headers'],
            self::SCENARIO_UPDATE => ['product_id', 'company_id', 'credentials', 'status', 'headers'],
            self::SCENARIO_DEFAULT => ['product_id', 'company_id', 'credentials', 'status', 'headers'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'company_id', 'status', 'credentials'], 'required'],
            [['product_id', 'company_id', 'status', 'added_by', 'updated_by'], 'integer'],
            [['credentials', 'added_on', 'updated_on', 'headers'], 'safe'],
            [['product_id', 'company_id'], 'unique', 'targetAttribute' => ['product_id', 'company_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Product',
            'company_id' => 'Company',
            'credentials' => 'Credentials',
            'headers' => 'Headers',
            'status' => 'Status',
            'added_on' => 'Added On',
            'updated_on' => 'Updated On',
            'added_by' => 'Added By',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * {@inheritdoc}
     * @return ProductCompanyMappingQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProductCompanyMappingQuery(get_called_class());
    }

    public function getProducts()
    {
        return $this->hasOne(Products::class, ['id' => 'product_id']);
    }

    public function getCompany()
    {
        return $this->hasOne(Company::class, ['id' => 'company_id']);
    }
}
