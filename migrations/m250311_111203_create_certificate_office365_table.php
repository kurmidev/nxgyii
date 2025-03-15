<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%certificate_office365}}`.
 */
class m250311_111203_create_certificate_office365_table extends Migration
{
    public $tableName = "certificate_office365";
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            "defaultDomain" => $this->string(),
            "groupExportType" => $this->string(),
            "groupsEnabled" => $this->string(),
            "id" => $this->string(),
            "name" => $this->string(),
            "oAuthStatus" => $this->json(),
            "organizationObjectId" => $this->string(),
            "userLockoutAction" => $this->string(),
            "userPasswordExpirationAction" => $this->string()
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
