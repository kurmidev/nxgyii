<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "products".
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property string|null $description
 * @property string $base_url
 * @property int $authentication_type
 * @property string|null $login_headers
 * @property string|null $auth_headers
 * @property int $status
 * @property string|null $login_endpoint
 * @property string|null $added_on
 * @property string|null $updated_on
 * @property int|null $added_by
 * @property int|null $updated_by
 *
 * @property ProductsApiCompanyMapping[] $productsApiCompanyMappings
 * @property ProductsApiList[] $productsApiLists
 */
class Products extends \app\models\BaseModel
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'products';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'code', 'base_url', 'authentication_type', 'status','login_endpoint'], 'required'],
            [['authentication_type', 'status', 'added_by', 'updated_by'], 'integer'],
            [['login_headers', 'auth_headers', 'added_on', 'updated_on'], 'safe'],
            [['name', 'code', 'description', 'base_url'], 'string', 'max' => 255],
            [['name', 'code'], 'unique', 'targetAttribute' => ['name', 'code']],
            ['login_headers', 'validateHeaders'],
            ['auth_headers', 'validateHeaders'],
        ];
    }

    public function scenarios()
    {
        return [
            self::SCENARIO_DEFAULT => ['*'], // Also tried without this line
            self::SCENARIO_CREATE => ['name', 'code', 'description', 'base_url', 'authentication_type', 'login_headers', 'auth_headers', 'status','login_endpoint'],
            self::SCENARIO_CONSOLE => ['name', 'code', 'description', 'base_url', 'authentication_type', 'login_headers', 'auth_headers', 'status','login_endpoint'],
            self::SCENARIO_UPDATE => ['id', 'name', 'code', 'description', 'base_url', 'authentication_type', 'login_headers', 'auth_headers', 'status','login_endpoint'],
        ];
    }

    public function beforeValidate()
    {
        return parent::beforeValidate();
    }

    public function validateHeaders($attribute, $params)
    {
        $i = 0;
        $errors = [];
        for ($i = 0; $i < count($this->attributes); $i++) {

            if ($i == 0 && empty($this->$attribute[$i]['key']) && empty($this->$attribute[$i]['val'])) {
                $this->addError($attribute . "[$i][key]", 'Key cannot be blank.');
                $this->addError($attribute . "[$i][val]", 'Value cannot be blank.');
            } else if (empty($this->$attribute[$i]['key']) && !empty($this->$attribute[$i]['val'])) {
                $this->addError($attribute . "[$i][key]", 'Key cannot be blank.');
            } else if (empty($this->$attribute[$i]['val']) && !empty($this->$attribute[$i]['key'])) {
                $this->addError($attribute . "[$i][val]", 'Value cannot be blank.');
            }
            $i++;
        }
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
            'description' => 'Description',
            'base_url' => 'Base Url',
            'authentication_type' => 'Authentication Type',
            'login_headers' => 'Login Headers',
            'auth_headers' => 'Auth Headers',
            'status' => 'Status',
            'login_endpoint' => 'Login Endpoint',
            'added_on' => 'Added On',
            'updated_on' => 'Updated On',
            'added_by' => 'Added By',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * Gets query for [[ProductsApiCompanyMappings]].
     *
     * @return \yii\db\ActiveQuery|ProductsApiCompanyMappingQuery
     */
    public function getProductsApiCompanyMappings()
    {
        return $this->hasMany(ProductsApiCompanyMapping::class, ['product_id' => 'id']);
    }

    /**
     * Gets query for [[ProductsApiLists]].
     *
     * @return \yii\db\ActiveQuery|ProductsApiListQuery
     */
    public function getProductsApiLists()
    {
        return $this->hasMany(ProductsApiList::class, ['product_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return ProductsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProductsQuery(get_called_class());
    }
}
