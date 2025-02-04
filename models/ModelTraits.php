<?php

namespace app\models;

use app\component\Utils;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\BaseActiveRecord;
use app\models\User;
use app\models\CodeSequence;
use yii\db\Expression;

trait ModelTraits
{
    /*
     * function to set the value for adddedon,addedby,updatedoon and updatedby
     * @return array
     */

    public function behaviors()
    {

        return [
            [
                'class' => BlameableBehavior::class,
                'createdByAttribute' => 'added_by',
                'updatedByAttribute' => 'updated_by',
                //                "value" => function () {
//                    return User::currentUser();
//                }
            ],
            [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    BaseActiveRecord::EVENT_BEFORE_INSERT => ['added_on'],
                    BaseActiveRecord::EVENT_BEFORE_UPDATE => 'updated_on',
                ],
                'value' => new Expression('NOW()'),
            ]
        ];
    }

    /*
     * function to get the latest change done
     * @return datetime
     */

    public function getActionOn()
    {
        return is_null($this->updated_on) ?
            Yii::$app->formatter->asDatetime($this->added_on, 'php:d M Y H:i') :
            Yii::$app->formatter->asDatetime($this->updated_on, 'php:d M Y H:i');
    }

    /*
     * function to get the user details
     * @return string
     */

    public function getActionBy()
    {

        $actiontaker = empty($this->updated_by) ? $this->added_by : $this->updated_by;
        $crdObj = User::findOne(['id' => $actiontaker]);

        if ($crdObj instanceof User) {
            return $crdObj->name;
        }
        return null;
    }

    public function generateCode($prefix, $fy = false)
    {
        $financialYrs = $fy ? Utils::Fy(date("Y-m-d")) . "-" : "";
        $prefix = $prefix . "-" . $financialYrs;
        $count = CodeSequence::getSequence($prefix);
        return $prefix . $count;
    }

    public function getAttributes($names = null, $except = array())
    {
        $fields = parent::getAttributes($names, $except);
        if (!empty($this->attrs) && $this->scenario == self::SCENARIO_DEFAULT) {
            foreach ($this->attrs as $labels => $attr) {
                $func = 'get' . ucwords($attr);
                if (method_exists($this, $func)) {
                    $fields[is_string($labels) ? $labels : $attr] = $this->$attr;
                }
            }
        }
        return $fields;
    }

    public function generateReceiptNo($transType)
    {
        return null;
    }

}
