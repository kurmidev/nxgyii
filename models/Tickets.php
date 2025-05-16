<?php

namespace app\models;

use app\component\Constants;
use Yii;

/**
 * This is the model class for table "tickets".
 *
 * @property int $id
 * @property string $subject
 * @property string $code
 * @property string $description
 * @property int $priority
 * @property int $category_id
 * @property int $sub_category_id
 * @property int $company_id
 * @property int|null $assign_to
 * @property string|null $zoho_id
 * @property string $start_date
 * @property string|null $end_date
 * @property int|null $rating
 * @property int $status
 * @property string|null $resolution
 * @property int $created_by
 * @property int $updated_by
 * @property int $created_at
 * @property int $updated_at
 */
class Tickets extends \app\models\BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tickets';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['subject', 'description', 'priority', 'category_id', 'sub_category_id', 'start_date', 'company_id'], 'required'],
            [['description', 'resolution','code'], 'string'],
            [['priority', 'category_id', 'sub_category_id', 'assign_to', 'rating', 'status', 'added_on', 'updated_on', 'added_by', 'updated_by', 'company_id'], 'integer'],
            [['start_date', 'end_date'], 'safe'],
            [['subject', 'zoho_id'], 'string', 'max' => 100],
        ];
    }

    public function scenarios()
    {
        return [
            self::SCENARIO_CREATE => ['subject', 'description', 'priority', 'category_id', 'sub_category_id', 'start_date', 'company_id','code'],
            self::SCENARIO_UPDATE => ['subject', 'description', 'priority', 'category_id', 'sub_category_id', 'start_date', 'company_id', 'assign_to', 'status', 'resolution','code','rating'],
            self::SCENARIO_DEFAULT => ['subject', 'description', 'priority', 'category_id', 'sub_category_id', 'start_date', 'company_id', 'assign_to', 'status', 'resolution','code','rating'],
        ];
    }

    public function beforeValidate()
    {

        if ($this->scenario == self::SCENARIO_CREATE) {
            $this->start_date = date("Y-m-d");    
            $user = User::currentUser();    
            if ($user->user_type == Constants::USERTYPE_CLIENT) {
                $this->company_id = $user->company_id;
            }
            $prefix = Constants::PREFIX_TICKET;
            if(!empty($this->company_id)) {
                $company = Company::findOne($this->company_id);
                $prefix = $company->code;
            }
            $this->code = empty($this->code) ? $this->generateCode($prefix) : $this->code;
            if(!empty($this->sub_category_id)){
                $subCategory = Categories::findOne($this->sub_category_id);
                $this->category_id = $subCategory->parent_id;
            }else{
                $this->addError("sub_category_id", "Sub Category is required.");
            }
        }

        return parent::beforeValidate();
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'subject' => 'Subject',
            'code'=>'Code',
            'description' => 'Description',
            'priority' => 'Priority',
            'category_id' => 'Category',
            'sub_category_id' => 'Sub Category',
            'assign_to' => 'Assign To',
            'zoho_id' => 'Zoho',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'rating' => 'Rating',
            'status' => 'Status',
            'resolution' => 'Resolution',
            'company_id' => 'Company',
            'added_on' => 'Added On',
            'updated_on' => 'Updated On',
            'added_by' => 'Added By',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * {@inheritdoc}
     * @return TicketsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TicketsQuery(get_called_class());
    }

    public function getCategory()
    {
        return $this->hasOne(Categories::class, ['id' => 'category_id']);
    }

    public function getSubCategory()
    {
        return $this->hasOne(Categories::class, ['id' => 'sub_category_id']);
    }

    public function getCompany()
    {
        return $this->hasOne(Company::class, ['id' => 'company_id']);
    }

    public function getComplaintReply(){
        return $this->hasMany(TicketComments::class, ['ticket_id' => 'id']);
    }

    public function beforeSave($insert){
        if($this->scenario == self::SCENARIO_UPDATE && !empty($this->resolution)){
            $this->end_date = date("Y-m-d");
        }
        return parent::beforeSave($insert);
    }
}
