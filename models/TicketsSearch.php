<?php

namespace app\models;

use app\component\Constants;
use app\component\Utils;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Tickets;
use yii\helpers\ArrayHelper;

/**
 * TicketsSearch represents the model behind the search form of `app\models\Tickets`.
 */
class TicketsSearch extends Tickets
{

    public $added_on_start;
    public $added_on_end;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'priority', 'category_id', 'sub_category_id', 'assign_to', 'rating', 'status', 'added_on', 'updated_on', 'added_by', 'updated_by','company_id'], 'integer'],
            [['subject', 'description', 'zoho_id', 'start_date', 'end_date', 'resolution', "added_on_start", "added_on_end",], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Tickets::find();
        $query->defaultCondition();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'priority' => $this->priority,
            'category_id' => $this->category_id,
            'sub_category_id' => $this->sub_category_id,
            'assign_to' => $this->assign_to,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'rating' => $this->rating,
            'status' => $this->status,
            'company_id'=>$this->company_id,
            'added_on' => $this->added_on,
            'updated_on' => $this->updated_on,
            'added_by' => $this->added_by,
            'updated_by' => $this->updated_by,
        ]);

        if (!empty($this->added_on_start) && !empty($this->added_on_end)) {
            $query->andWhere(['between', $query->talias . 'added_on', $this->added_on_start, Utils::getEndDate($this->added_on_end)]);
        }

        $query->andFilterWhere(['like', 'subject', $this->subject])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'zoho_id', $this->zoho_id])
            ->andFilterWhere(['like', 'resolution', $this->resolution]);

        return $dataProvider;
    }

    public function advanceSearch($type = "")
    {
        return [
            ["label" => "priority", "attribute" => "priority", "type" => "dropdown", "list" => Constants::LABEL_PRIORITY],
            ["label" => "Category", "attribute" => "category_id", "type" => "dropdown", "list" => ArrayHelper::map(Categories::find()->active()->andWhere(['parent_id' =>0])->asArray()->all(), "id", "name")],
            ["label" => "Sub Category", "attribute" => "sub_category_id", "type" => "dropdown", "list" => ArrayHelper::map(Categories::find()->active()->andWhere([">",'parent_id',0])->asArray()->all(), "id", "name")],
            ["label" => "Status", "attribute" => "status", "type" => "dropdown", "list" => Constants::LABEL_COMPLAINT_STATUS],
            ["label" => "Added On", "attribute" => "added_on", "type" => "date_range"],
            ["label" => "Company", "attribute" => "company_id", "type" => "dropdown", "list" => ArrayHelper::map(Company::find()->active()->asArray()->all(), "id", "name")],
        ];

    }
}
