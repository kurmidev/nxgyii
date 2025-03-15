<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%jumpcloud_devices}}`.
 */
class m250310_153509_create_jumpcloud_devices_table extends Migration
{
    public $tableName = "jumpcloud_devices";
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            "organization" => $this->string(),
            "created" => $this->string(),
            "lastContact" => $this->string(),
            "os" => $this->string(),
            "osFamily" => $this->string(),
            "version" => $this->string(),
            "arch" => $this->string(),
            "archFamily" => $this->string(),
            "networkInterfaces" => $this->json(),
            "hostname" => $this->string(),
            "displayName" => $this->string(),
            "systemTimezone" => $this->string(),
            "templateName" => $this->string(),
            "remoteIP" => $this->string(),
            "active" => $this->string(),
            "sshdParams" => $this->json(),
            "allowSshPasswordAuthentication" => $this->string(),
            "allowSshRootLogin" => $this->string(),
            "allowMultiFactorAuthentication" => $this->string(),
            "allowPublicKeyAuthentication" => $this->string(),
            "modifySSHDConfig" => $this->string(),
            "agentVersion" => $this->string(),
            "connectionHistory" => $this->json(),
            "sshRootEnabled" => $this->string(),
            "id" => $this->string(),
            "_id" => $this->string(),
            "hwVendor" => $this->string(),
            "remoteAssistAgentVersion" => $this->string(),
            "serialNumber" => $this->string(),
            "fde" => $this->json(),
            "systemInsights" => $this->json(),
            "hasServiceAccount" => $this->string(),
            "fileSystem" => $this->string(),
            "mdm" => $this->json(),
            "domainInfo" => $this->json(),
            "usernameHashes" => $this->string(),
            "userMetrics" => $this->json(),
            "serviceAccountState" => $this->string(),
            "osVersionDetail" => $this->json(),
            "azureAdJoined" => $this->string(),
            "description" => $this->string(),
            "desktopCapable" => $this->string(),
            "policyStats" => $this->json(),
            "isPolicyBound" => $this->string()
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
