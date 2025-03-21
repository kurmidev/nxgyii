<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%threat_data}}`.
 */
class m250321_051809_create_threat_data_table extends Migration
{
    private $tableName = "threat_data";
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            "src_host_name" => $this->string(),
            "src_network_name" => $this->string(),
            "user_name" => $this->json(),
            "message" => $this->json(),
            "event_category" => $this->json(),
            "event_type_name" => $this->json(),
            "source_data_type" => $this->json(),
            "src_ip" => $this->json(),
            "event_origin" => $this->json(),
            "dst_host_name" => $this->json(),
            "event_id" => $this->json(),
            "additional_info" => $this->json(),
            "dest_ip" => $this->string(),
            "mitre_technique_id" => $this->json(),
            "timestamp" => $this->string(),
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
