<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%alert_analysis}}`.
 */
class m250318_132935_create_alert_analysis_table extends Migration
{
    private $tableName = "alert_analysis";

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            "id"=> $this->primaryKey(),
            "tenant_id" => $this->string(),
            "alert_severity" => $this->string(),
            "alert_severity_score" => $this->string(),
            "rpca_updated" => $this->string(),
            "alert_type" => $this->string(),
            "source_data_type_list" => $this->json(),
            "update_time" => $this->string(),
            "object_network_name" => $this->string(),
            "alert_id" => $this->string(),
            "situation_name" => $this->string(),
            "severity" => $this->string(),
            "alert_type_id" => $this->string(),
            "create_time" => $this->string(),
            "mitre_tid_list" => $this->json(),
            "message" => $this->string(),
            "object_id" => $this->string(),
            "event_origin_list" => $this->json(),
            "alert_status" => $this->string(),
            "prev_situation_id" => $this->string(),
            "is_uda" => $this->string(),
            "tm_id" => $this->string(),
            "alert_score" => $this->string(),
            "prev_alert_status" => $this->string(),
            "situation_id" => $this->string(),
            "recent_event_timestamp" => $this->string(),
            "is_severity_changed" => $this->string(),
            "entity" => $this->json(),
            "user_name" => $this->string(),
            "full_name" => $this->string(),
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
