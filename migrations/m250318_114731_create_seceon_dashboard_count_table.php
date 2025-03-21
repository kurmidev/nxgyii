<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%seceon_dashboard_count}}`.
 */
class m250318_114731_create_seceon_dashboard_count_table extends Migration
{
    public $tableName = "seceon_dashboard";
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            "id"=> $this->primaryKey(),
            "tenant_id" => $this->string(),
            "max_eps" => $this->string(),
            "avg_eps" => $this->string(),
            "events" => $this->string(),
            "threats" => $this->string(),
            "critical" => $this->string(),
            "major" => $this->string(),
            "minor" => $this->string(),
            "closed" => $this->string(),
            "remediated" => $this->string(),
            "assigned" => $this->string(),
            "trend" => $this->json(),
            "system" => $this->string(),
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
