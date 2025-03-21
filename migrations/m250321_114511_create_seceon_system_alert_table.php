<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%seceon_system_alert}}`.
 */
class m250321_114511_create_seceon_system_alert_table extends Migration
{
    private $tableName = "seceon_system_alert";
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            "system_event_severity" => $this->string(),
            "system_event_id" => $this->string(),
            "system_event_type_id" => $this->string(),
            "system_event_type" => $this->string(),
            "message" => $this->text(),
            "object" => $this->json(),
            "alert_id" => $this->string(),
            "alert_status" => $this->string(),
            "alert_type" => $this->string(),
            "alert_type_id" => $this->string(),
            "create_time" => $this->string(),
            "update_time" => $this->string(),
            "severity" => $this->string(),
            "tenant_id" => $this->string(),
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
