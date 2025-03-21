<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%seceon_alert_data}}`.
 */
class m250318_122038_create_seceon_alert_data_table extends Migration
{
    public $tableName = "seceon_alert_data";
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            "id"=> $this->primaryKey(),
            "critical" => $this->integer(),
            "major" => $this->integer(),
            "system" => $this->integer(),
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
