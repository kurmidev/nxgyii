<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%seceon_tenant}}`.
 */
class m250320_114501_create_seceon_tenant_table extends Migration
{
    private $tableName = "seceon_tenant";
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            "id"=> $this->primaryKey(),
            'tenant_id' => $this->string(),
            'tenant_name' => $this->string(),
            'EDR' => $this->string(),
            'openvas' => $this->string(),
            'lts' => $this->string(),
            'tenant_location' => $this->string(),
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
