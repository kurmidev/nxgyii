<?php

use app\component\Constants;
use yii\db\Migration;

/**
 * Handles the creation of table `{{%company}}`.
 */
class m250201_064017_create_company_table extends Migration
{
    protected $tableName = "company";
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
            "gst_in" => $this->string(),
            "pan_no" => $this->string(),
            "billing_address" => $this->string()->notNull(),
            "pincode" => $this->string(),
            "logo" => $this->string(),
            'status' => $this->smallInteger()->notNull()->defaultValue(Constants::STATUS_ACTIVE),
            'added_on' => $this->dateTime()->notNull()->defaultExpression('now()'),
            'updated_on' => $this->dateTime()->null(),
            'added_by' => $this->integer(),
            'updated_by' => $this->integer()
        ]);

        $this->createIndex(
            'idx-' . $this->tableName . '-status',
            $this->tableName,
            ['status']
        );
        $this->createIndex(
            'idx-' . $this->tableName . '-name',
            $this->tableName,
            ['name'],
            1
        );
        $this->createIndex(
            'idx-' . $this->tableName . '-code',
            $this->tableName,
            ['code'],
            1
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
