<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "products_api_list".
 *
 * @property int $id
 * @property int $product_id
 * @property string $api_name
 * @property string $api_endpoint
 * @property string $api_method
 * @property string|null $api_params
 * @property string|null $api_headers
 * @property string|null $api_body
 * @property int $is_pagination
 * @property int $status
 * @property string|null $added_on
 * @property string|null $updated_on
 * @property int|null $added_by
 * @property int|null $updated_by
 *
 * @property Products $product
 * @property ProductsApiCompanyMapping[] $productsApiCompanyMappings
 */
class ProductsApiList extends \app\models\BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'products_api_list';
    }

    public function scenarios()
    {
        return [
            self::SCENARIO_CREATE => ['product_id', 'api_name', 'api_endpoint', 'api_method', 'status', 'api_params', 'api_headers', 'api_body','is_pagination' ],
            self::SCENARIO_UPDATE => ['product_id', 'api_name', 'api_endpoint', 'api_method', 'status', 'api_params', 'api_headers', 'api_body','is_pagination'],
            self::SCENARIO_DELETE => ['status'],
            self::SCENARIO_DEFAULT => ['product_id', 'api_name', 'api_endpoint', 'api_method', 'api_params', 'api_headers', 'api_body', 'status', 'added_on', 'updated_on', 'added_by', 'updated_by','is_pagination'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'api_name', 'api_endpoint', 'api_method', 'status','is_pagination'], 'required'],
            [['product_id', 'status', 'added_by', 'updated_by'], 'integer'],
            [['api_params', 'api_headers', 'api_body', 'api_response', 'added_on', 'updated_on'], 'safe'],
            [['api_name', 'api_endpoint', 'api_method'], 'string', 'max' => 255],
            [['product_id', 'api_name'], 'unique', 'targetAttribute' => ['product_id', 'api_name']],
            //[['api_endpoint'], 'unique'],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Products::class, 'targetAttribute' => ['product_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Product ',
            'api_name' => 'Api Name',
            'api_endpoint' => 'Api Endpoint',
            'api_method' => 'Api Method',
            'api_params' => 'Api Params',
            'api_headers' => 'Api Headers',
            'api_body' => 'Api Body',
            'api_response' => 'Api Response',
            'status' => 'Status',
            'added_on' => 'Added On',
            'updated_on' => 'Updated On',
            'added_by' => 'Added By',
            'updated_by' => 'Updated By',
        ];
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

    public function beforeValidate()
    {
        
        if (!empty($this->api_params)) {
            $this->api_params = $this->sanitizeParams($this->api_params);
        }

        if (!empty($this->api_headers)) {
            $this->api_headers = $this->sanitizeParams($this->api_headers);
        }

        // if (!empty($this->api_body)) {
        //     $this->api_body = $this->sanitizeParams($this->api_body);
        // }
        if (!empty($this->api_response)) {
            $this->api_response = $this->sanitizeParams($this->api_response);
        }
        
        return parent::beforeValidate();
    }


    private function sanitizeParams($params)
    {
        $resp = [];
        foreach ($params as $key => $value) {
            if (!empty($value['val'])) {
                array_push($resp, $value);
            }
        }
        return $resp;
    }


    /**
     * Gets query for [[ProductsApiCompanyMappings]].
     *
     * @return \yii\db\ActiveQuery|ProductsApiCompanyMappingQuery
     */
    public function getProductsApiCompanyMappings()
    {
        return $this->hasMany(ProductsApiCompanyMapping::class, ['api_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return ProductsApiListQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProductsApiListQuery(get_called_class());
    }

    public function getCollectionName(){
        return strtolower(preg_replace('/[^a-z0-9_]/i', '_', $this->api_name . "_" . $this->id));
    }
}
