<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%jumpcloud_organization}}`.
 */
class m250315_084453_create_jumpcloud_organization_table extends Migration
{
    public $tableName = "jumpcloud_organization";
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->string(),
            '_id' => $this->string(),
            "displayName" => $this->string(),
            "logoUrl" => $this->string(),
            "created" => $this->string(),
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
