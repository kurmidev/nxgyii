<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "products_api_company_mapping".
 *
 * @property int $id
 * @property int $product_id
 * @property int $company_id
 * @property int $api_id
 * @property string $report_name
 * @property int $display_type
 * @property string|null $filters
 * @property string|null $display_columns
 * @property int $on_main_dashboard
 * @property int $status
 * @property string|null $added_on
 * @property string|null $updated_on
 * @property int|null $added_by
 * @property int|null $updated_by
 *
 * @property ProductsApiList $api
 * @property Company $company
 * @property Products $product
 */
class ProductsApiCompanyMapping extends \app\models\BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'products_api_company_mapping';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'company_id', 'api_id', 'report_name', 'display_type', 'on_main_dashboard', 'status'], 'required'],
            [['product_id', 'company_id', 'api_id', 'display_type', 'on_main_dashboard', 'status', 'added_by', 'updated_by'], 'integer'],
            [['filters', 'display_columns', 'added_on', 'updated_on'], 'safe'],
            [['report_name'], 'string', 'max' => 255],
            [['api_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductsApiList::class, 'targetAttribute' => ['api_id' => 'id']],
            [['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => Company::class, 'targetAttribute' => ['company_id' => 'id']],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Products::class, 'targetAttribute' => ['product_id' => 'id']],
        ];
    }

    public function scenarios(){
        return [
            ProductsApiCompanyMapping::SCENARIO_CREATE => ['product_id','company_id','api_id','report_name','display_type','filters','display_columns','on_main_dashboard','status'],
            ProductsApiCompanyMapping::SCENARIO_UPDATE => ['product_id','company_id','api_id','report_name','display_type','filters','display_columns','on_main_dashboard','status'],
            ProductsApiCompanyMapping::SCENARIO_DEFAULT=> ['product_id','company_id','api_id','report_name','display_type','filters','display_columns','on_main_dashboard','status'],
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
            'company_id' => 'Company ID',
            'api_id' => 'Api ID',
            'report_name' => 'Report Name',
            'display_type' => 'Display Type',
            'filters' => 'Filters',
            'display_columns' => 'Display Columns',
            'on_main_dashboard' => 'On Main Dashboard',
            'status' => 'Status',
            'added_on' => 'Added On',
            'updated_on' => 'Updated On',
            'added_by' => 'Added By',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * Gets query for [[Api]].
     *
     * @return \yii\db\ActiveQuery|ProductsApiListQuery
     */
    public function getApi()
    {
        return $this->hasOne(ProductsApiList::class, ['id' => 'api_id']);
    }

    /**
     * Gets query for [[Company]].
     *
     * @return \yii\db\ActiveQuery|CompanyQuery
     */
    public function getCompany()
    {
        return $this->hasOne(Company::class, ['id' => 'company_id']);
    }

    /**
     * Gets query for [[Product]].
     *
     * @return \yii\db\ActiveQuery|ProductsQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Products::class, ['id' => 'product_id']);
    }

    /**
     * {@inheritdoc}
     * @return ProductsApiCompanyMappingQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProductsApiCompanyMappingQuery(get_called_class());
    }
}
