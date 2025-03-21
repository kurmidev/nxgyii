<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%seceon_event_data}}`.
 */
class m250320_125456_create_seceon_event_data_table extends Migration
{
    private $tableName = "seceon_event_data";
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            "id"=> $this->primaryKey(),
            "cce_host" => $this->string(),
            "cce_ip" => $this->string(),
            "device_type" => $this->string(),
            "cce_version" => $this->string(),
            "device_name" => $this->string(),
            "device_ip" => $this->string(),
            "last_seen" => $this->string(),
            "total_count" => $this->string(),
            "tenant_id" => $this->string(),
            "log_type" => $this->string()
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
