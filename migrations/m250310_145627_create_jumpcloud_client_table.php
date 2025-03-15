<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%jumpcloud_client}}`.
 */
class m250310_145627_create_jumpcloud_client_table extends Migration
{
    public $tableName = "jumpcloud_client";
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            "account_locked" => $this->string(),
            "activated" => $this->string(),
            "addresses" => $this->json(),
            "allow_public_key" => $this->string(),
            "alternateEmail" => $this->string(),
            "attributes" => $this->json(),
            "company" => $this->string(),
            "costCenter" => $this->string(),
            "department" => $this->string(),
            "description" => $this->string(),
            "disableDeviceMaxLoginAttempts" => $this->string(),
            "displayname" => $this->string(),
            "email" => $this->string(),
            "employeeIdentifier" => $this->string(),
            "employeeType" => $this->string(),
            "enable_managed_uid" => $this->string(),
            "enable_user_portal_multifactor" => $this->string(),
            "external_dn" => $this->string(),
            "external_source_type" => $this->string(),
            "externally_managed" => $this->string(),
            "firstname" => $this->string(),
            "jobTitle" => $this->string(),
            "lastname" => $this->string(),
            "ldap_binding_user" => $this->string(),
            "location" => $this->string(),
            "managedAppleId" => $this->string(),
            "manager" => $this->string(),
            "mfa" => $this->json(),
            "middlename" => $this->string(),
            "password_never_expires" => $this->string(),
            "passwordless_sudo" => $this->string(),
            "phoneNumbers" => $this->json(),
            "restrictedFields" => $this->json(),
            "samba_service_user" => $this->string(),
            "ssh_keys" => $this->json(),
            "state" => $this->string(),
            "sudo" => $this->string(),
            "suspended" => $this->string(),
            "systemUsername" => $this->string(),
            "unix_guid" => $this->string(),
            "unix_uid" => $this->string(),
            "username" => $this->string(),
            "creationSource" => $this->string(),
            "created" => $this->string(),
            "organization" => $this->string(),
            "password_date" => $this->string(),
            "password_expired" => $this->string(),
            "totp_enabled" => $this->string(),
            "_id" => $this->string(),
            "id" => $this->string(),
            "mfaEnrollment" => $this->json()
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
