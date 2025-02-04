<?php

namespace app\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\BaseActiveRecord;
use yii\db\Expression;
use app\models\User;


class BaseModel extends \yii\db\ActiveRecord {

    use BaseTraits;
    use ModelTraits;

    const SCENARIO_DEFAULT = 'default';
    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';
    const SCENARIO_DELETE = 'delete';
    const SCENARIO_CONSOLE = 'console';
    const SCENARIO_MIGRATE = 'migrate';
    const SCENARIO_DWNFIELDS = 'dwn_fields'; // Download Fields
    const SCENARIO_BULK_ACTIVITY = 'bulkActivity'; // Download Fields

    public $alias;

    public function setAlias($alias) {
        $this->alias = "$alias.";
    }

    public function addRemark($remark) {
        if (!empty($remark) && $this->hasAttribute("remark")) {
            $r = $this->remark;
            $r[date("Y-m-d H:i:s")] = $remark;
            $this->remark = $r;
        }
    }

    public function getAddedOnDate() {
        return date("d-m-y H:i", strtotime($this->added_on));
    }

    public function getAddedByUser() {
        return $this->hasOne(User::class, ['id' => 'added_by']);
    }

    public function getAddedByName() {
        return !empty($this->addedByUser) ? $this->addedByUser->name : "";
    }

}
