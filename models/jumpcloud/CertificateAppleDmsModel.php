<?php

namespace app\models\jumpcloud;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

class CertificateAppleDmsModel extends ActiveRecord{

    public static function tableName(){
        return 'certificate_apple_dms';
    }

    public function attributes(){
        return ["ades","allowMobileUserEnrollment","apnsCertExpiry","apnsPushTopic","appleCertCreatorAppleID","appleCertSerialNumber","defaultIosUserEnrollmentDeviceGroupID","dep","depServerTokenState","id","name","organization"];
    }

    public function rules(){
        return [
            [['ades','allowMobileUserEnrollment','apnsCertExpiry','apnsPushTopic','appleCertCreatorAppleID','appleCertSerialNumber','defaultIosUserEnrollmentDeviceGroupID','dep','depServerTokenState','id','name','organization'],'safe'],
        ];
    }

    public static function find(){
        return new CertificateAppleDmsQuery(get_called_class());
    }
}

class CertificateAppleDmsQuery extends ActiveQuery{

}

