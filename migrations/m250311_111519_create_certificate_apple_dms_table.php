<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%certificate_apple_dms}}`.
 */
class m250311_111519_create_certificate_apple_dms_table extends Migration
{
    public $tableName = "certificate_apple_dms";
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            "ades" => $this->json(),
            "allowMobileUserEnrollment" => $this->string(),
            "apnsCertExpiry" => $this->string(),
            "apnsPushTopic" => $this->string(),
            "appleCertCreatorAppleID" => $this->string(),
            "appleCertSerialNumber" => $this->string(),
            "defaultIosUserEnrollmentDeviceGroupID" => $this->string(),
            "dep" => $this->json(),
            "depServerTokenState" => $this->string(),
            "id" => $this->string(),
            "name" => $this->string(),
            "organization" => $this->string(),
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
