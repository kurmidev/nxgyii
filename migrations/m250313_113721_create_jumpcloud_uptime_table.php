<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%jumpcloud_uptime}}`.
 */
class m250313_113721_create_jumpcloud_uptime_table extends Migration
{
    public $tableName = "jumpcloud_uptime";
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            "days" => $this->integer(),
            "hours" => $this->integer(),
            "minutes" => $this->integer(),
            "seconds" => $this->integer(),
            "total_seconds" => $this->integer(),
            "system_id" => $this->string(),
            "collection_time" => $this->integer()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->tableName);
    }
}
