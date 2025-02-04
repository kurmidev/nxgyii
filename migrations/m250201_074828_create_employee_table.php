<?php

use app\component\Constants;
use yii\db\Migration;

/**
 * Handles the creation of table `{{%employee}}`.
 */
class m250201_074828_create_employee_table extends Migration
{
    protected $tableName = 'employee';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            "name" => $this->string()->notNull()->unique(),
            "code" => $this->string()->notNull()->unique(),
            "mobile_no" => $this->string()->notNull(),
            "phone_no" => $this->string(),
            "email" => $this->string(),
            "address" => $this->string()->notNull(),
            "pincode" => $this->string(),
            "company_id"=> $this->integer(),
            "designation_id"=> $this->integer(),
            'status' => $this->smallInteger()->notNull()->defaultValue(Constants::STATUS_ACTIVE),
            'added_on' => $this->dateTime()->notNull()->defaultExpression('now()'),
            'updated_on' => $this->dateTime()->null(),
            'added_by' => $this->integer(),
            'updated_by' => $this->integer()
        ]);
        $this->createIndex(
            'idx-'. $this->tableName. '-code',
            $this->tableName,
            ['code'],
            1
        );
        $this->addForeignKey(
            'fk-employee-company_id',
            $this->tableName,
            'company_id',
            'company',
            'id',
        );
        $this->addForeignKey(
            'fk-employee-designation_id',
            $this->tableName,
            'designation_id',
            'designation',
            'id',
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->tableName);
    }
}
