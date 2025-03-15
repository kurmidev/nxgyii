<?php

namespace app\models\jumpcloud;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

class DeviceModel extends ActiveRecord{

    public static function tableName(){
        return 'jumpcloud_devices';
    }

    public function rules(){
        return [
            [["organization","created","lastContact","os","osFamily","version","arch","archFamily","networkInterfaces","hostname","displayName","systemTimezone","templateName","remoteIP","active","sshdParams","allowSshPasswordAuthentication","allowSshRootLogin","allowMultiFactorAuthentication","allowPublicKeyAuthentication","modifySSHDConfig","agentVersion","connectionHistory","sshRootEnabled","id","_id","hwVendor","remoteAssistAgentVersion","serialNumber","fde","systemInsights","hasServiceAccount","fileSystem","mdm","domainInfo","usernameHashes","userMetrics","serviceAccountState","osVersionDetail","azureAdJoined","description","desktopCapable","policyStats","isPolicyBound"],"safe"]
        ];
    }

    public function attributes(){
        return ["organization","created","lastContact","os","osFamily","version","arch","archFamily","networkInterfaces","hostname","displayName","systemTimezone","templateName","remoteIP","active","sshdParams","allowSshPasswordAuthentication","allowSshRootLogin","allowMultiFactorAuthentication","allowPublicKeyAuthentication","modifySSHDConfig","agentVersion","connectionHistory","sshRootEnabled","id","_id","hwVendor","remoteAssistAgentVersion","serialNumber","fde","systemInsights","hasServiceAccount","fileSystem","mdm","domainInfo","usernameHashes","userMetrics","serviceAccountState","osVersionDetail","azureAdJoined","description","desktopCapable","policyStats","isPolicyBound"];
    }

    public static function find()
    {
        return new DeviceQuery(get_called_class());
    }
}

class DeviceQuery extends ActiveQuery{
    
    function inactiveDevice(){
        return $this->andWhere([">",'lastContact',date('Y-m-d 00:00:00', strtotime('-7 days'))]);
    }
}