<?php 

namespace app\models\jumpcloud;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

class CertificateOffice365Model extends ActiveRecord{

    public static function tableName(){
        return 'certificate_office365';
    }
    public function attributes(){
        return ["defaultDomain","groupExportType","groupsEnabled","id","name","oAuthStatus","organizationObjectId","userLockoutAction","userPasswordExpirationAction"];
    }

    public function rules(){
        return [
            [['defaultDomain','groupExportType','groupsEnabled','id','name','oAuthStatus','organizationObjectId','userLockoutAction','userPasswordExpirationAction'],'safe'],
        ];
    }

    public static function find(){
        return new CertificateOffice365Query(get_called_class());
    }
}

class CertificateOffice365Query extends ActiveQuery{

}
