<?php

namespace app\models\jumpcloud;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

class ClientModel extends ActiveRecord
{

    public static function tableName(){
        return 'jumpcloud_client';
    }

    public function rules()
    {
        return [
            [["account_locked", "activated", "addresses", "allow_public_key", "alternateEmail", "attributes", "company", "costCenter", "department", "description", "disableDeviceMaxLoginAttempts", "displayname", "email", "employeeIdentifier", "employeeType", "enable_managed_uid", "enable_user_portal_multifactor", "external_dn", "external_source_type", "externally_managed", "firstname", "jobTitle", "lastname", "ldap_binding_user", "location", "managedAppleId", "manager", "mfa", "middlename", "password_never_expires", "passwordless_sudo", "phoneNumbers", "restrictedFields", "samba_service_user", "ssh_keys", "state", "sudo", "suspended", "systemUsername", "unix_guid", "unix_uid", "username", "creationSource", "created", "organization", "password_date", "password_expired", "totp_enabled", "_id", "id", "mfaEnrollment"], 'safe']
        ];
    }
    public function attributes()
    {
        return ["account_locked", "activated", "addresses", "allow_public_key", "alternateEmail", "attributes", "company", "costCenter", "department", "description", "disableDeviceMaxLoginAttempts", "displayname", "email", "employeeIdentifier", "employeeType", "enable_managed_uid", "enable_user_portal_multifactor", "external_dn", "external_source_type", "externally_managed", "firstname", "jobTitle", "lastname", "ldap_binding_user", "location", "managedAppleId", "manager", "mfa", "middlename", "password_never_expires", "passwordless_sudo", "phoneNumbers", "restrictedFields", "samba_service_user", "ssh_keys", "state", "sudo", "suspended", "systemUsername", "unix_guid", "unix_uid", "username", "creationSource", "created", "organization", "password_date", "password_expired", "totp_enabled", "_id", "id", "mfaEnrollment"];
    }

    public static function find()
    {
        return new ClientQuery(get_called_class());
    }
}

class ClientQuery extends ActiveQuery
{
    function passwordExpired()
    {
        return $this->andWhere(['password_expired' => true]);
    }

    function accountLocked()
    {
        return $this->andWhere(['account_locked' => true]);
    }

    function upcomingPasswordExpiring()
    {
        return $this->andWhere(['>=', 'password_date', date('Y-m-d 00:00:00', strtotime('-7 days'))])
            ->andWhere(['<=', 'password_date', date('Y-m-d 23:59:59')]);
    }

    function administrativeUser()
    {
        return $this->andWhere(['sudo' => true]);
    }
    function newUserIn7Days()
    {
        return $this->andWhere(['>=', 'created', date('Y-m-d', strtotime('-7 days'))])
            ->andWhere(['<=', 'created', date('Y-m-d', strtotime('-7 days'))]);
    }

    function scheduledUserSuspension()
    {
        return $this->andWhere(['suspended' => true]);
    }
}