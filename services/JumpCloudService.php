<?php

namespace app\services;

use app\component\Utils;
use app\models\jumpcloud\CatalogModel;
use app\models\jumpcloud\CertificateAppleDmsModel;
use app\models\jumpcloud\CertificateOffice365Model;
use app\models\jumpcloud\ClientModel;
use app\models\jumpcloud\DeviceModel;
use app\models\jumpcloud\OrganizationModel;
use app\models\jumpcloud\UpTimeModel;
use Yii;
use yii\helpers\ArrayHelper;

class JumpCloudService implements IDashborad
{

    public $params;

    public function __construct(array $params = [])
    {
        $this->params = $params;
    }
    public static $endPoints = [
        "app\models\jumpcloud\ClientModel" => "/systemusers",
        "app\models\jumpcloud\DeviceModel" => "/systems",
        "app\models\jumpcloud\CertificateOffice365Model" => "/v2/office365s?limit=100",
        "app\models\jumpcloud\CertificateAppleDmsModel" => "/v2/applemdms?limit=100",
        "app\models\jumpcloud\CatalogModel" => "/v2/software/catalog?limit=100",
        "app\models\jumpcloud\UpTimeModel" => "/v2/systeminsights/uptime?limit=100",
        "app\models\jumpcloud\OrganizationModel" => "/organizations"
    ];

    public static $baseUrl = "https://console.jumpcloud.com/api";


    public function getData($request): array
    {
        // TODO: Implement getData() method.
        return [];
    }

    public function getDashboardCounts(): array
    {
        return [
            "total_user" => ClientModel::find()->count(),
            "total_device" => DeviceModel::find()->where(['active' => 1])->count(),
            "administer" => ClientModel::find()->count(),
            "lockouts" => ClientModel::find()->where(["account_locked" => "true"])->count(),//account_locked:eq:true
            "password_expired" => ClientModel::find()->where(["password_expired" => "true"])->count(),//password_expired:eq:true
            "password_about_expiring" => ClientModel::find()
                ->where([
                    "between",
                    "cast(password_date as date)",
                    date("Y-m-d"),
                    date(
                        "Y-m-d",
                        strtotime("+7 days")
                    )
                ])
                ->andWhere(["password_expired" => true])->count(),
            //password_expiration_date:$gte:2025-03-13 , password_expiration_date:$lte:2025-03-27 , password_expired:eq:false
            "new_user" => ClientModel::find()->where([">", "cast(created as date)", date("Y-m-d", strtotime("-7 days"))])->count(), //created:$gte:2025-03-06
            "sudo_access" => ClientModel::find()->where(["sudo" => true])->count(),// /api/systemusers  sudo:eq:true
            "admin_sudo_access" => ClientModel::find()->where(["sudo" => "true"])->count(),///api/systemusers sudo:eq:true
            "without_mfa" => ClientModel::find()->where(["json_unquote(json_extract(mfaEnrollment,'$.totpStatus'))" => "NOT_ENROLLED"])->count(),///api/users enableMultiFactor:eq:false
            "suspended_user" => ClientModel::find()->where(["suspended" => "true"])->count(),///api/v2/bulk/userstates   state:eq:SUSPENDED,scheduled_date:lt:2025-06-11
            "release_trains" => CatalogModel::find()->groupBy(["operatingSystem"])->where([">", "cast(releaseTimestamp as date)", date("Y-m-d", strtotime("-14 days"))])->select(["operatingSystem as label", "sum(id) as count"])->asArray()->all(),///api/v2/software/catalog operatingSystem:search:Windows,MacOS,Ubuntu
            "reports_ready" => 0,// /api/v2/directoryinsights/reports
            "alerts" => 0,///api/v2/alerts-stats  groupBy[]:GROUP_BY_STATUS TODO:need to integrate it
            "scheduled_activation" => 0,///api/v2/bulk/userstates   state:eq:ACTIVATED,scheduled_date:lt:2025-06-11

            "organization" => OrganizationModel::find()->count(),//https://console.jumpcloud.com/api/organizations?limit=100&skip=0&fields[0]=id&fields[1]=displayName&fields[2]=logoUrl&fields[3]=applicationsCount&fields[4]=systemsCount&fields[5]=systemUsersCount&fields[6]=created
            "user_notification" => [
                ["label" => "Users with admin sudo access", "count" => ClientModel::find()->where(["sudo" => true])->count()],
                //https://console.jumpcloud.com/api/systemusers?limit=100&skip=0&filter[0]=sudo:eq:true
                ["label" => "Users with admin sudo access", "count" => ClientModel::find()->where(["passwordless_sudo" => "true"])->count()],//https://console.jumpcloud.com/api/systemusers?limit=100&skip=0&filter[0]=passwordless_sudo:eq:true
            ],
            "device_notifications" => [
                ["label" => "Devices inactive greater than 7 days", "count" => DeviceModel::find()->where(['active' => 0])->andWhere(["<=", "cast(lastContact as datetime)", date("Y-m-d H:i:s", strtotime("-7 days"))])->count()],//api/systems  active:eq:false, lastContact:$lte:2025-03-06],
                //https://console.jumpcloud.com/api/systems?skip=0&limit=100&filter[0]=active:eq:false&filter[1]=lastContact:$lte:2025-03-08
                ["label" => "Devices inactive greater than 7 days ", "count" => UpTimeModel::find()->where([">", "total_seconds", 0])->count()],//ttps://console.jumpcloud.com/api/v2/systeminsights/uptime?skip=100&limit=100&filter=total_seconds:gte:0
            ],
            "certificates" => $this->generateCertificateData()
        ];
    }

    public function generateCertificateData()
    {
        $organizations = ArrayHelper::map(OrganizationModel::find()->asArray()->all(), 'id', "displayname");
        $expired = $notexpired = 0;
        $list = [];
        $cerficate1 = CertificateAppleDmsModel::find()->asArray()->all();
        $cerficate2 = CertificateOffice365Model::find()->asArray()->all();
        foreach ($cerficate1 as $c) {
            $daysLeft = !empty($c["apnscertexpiry"]) ? date("d", strtotime("now") - strtotime($c["apnscertexpiry"])) : 0;
            $list[] = [
                "organization" => !empty($organizations[$c["organization"]]) ? $organizations[$c["organization"]] : "",
                "expiryDate" => !empty($c["apnscertexpiry"]) ? date("Y-m-d", strtotime($c["apnscertexpiry"])) : "",
                "days_left" => $daysLeft > 0 ? $daysLeft : 0,
                "status"=> $daysLeft > 0 ? "Active" : "Expired",
            ];
            if ($daysLeft <= 0) {
                $expired++;
            } else {
                $notexpired++;
            }
        }

        foreach ($cerficate2 as $c) {

            $oauthstatus = json_decode($c["oauthstatus"], true);
            $daysLeft = !empty($oauthstatus["expiry"]["seconds"]) ? Utils::getDayDiff(date("Y-m-d H:i:s"), date("Y-m-d H:i:s", $oauthstatus["expiry"]["seconds"])) : 0;
            $list[] = [
                "organization" => !empty($organizations[$c["organizationobjectid"]]) ? $organizations[$c["organizationobjectid"]] : "",
                "expiryDateww" => !empty($oauthstatus["expiry"]["seconds"]) ? date("Y-m-d", $oauthstatus["expiry"]["seconds"]) : "",
                "days_left" => $daysLeft > 0 ? $daysLeft : 0,
                "status"=> $daysLeft > 0 ? "Active" : "Expired",
            ];
            if ($daysLeft <= 0) {
                $expired++;
            } else {
                $notexpired++;
            }
        }


        return [
            "data" => [
                ["label" => "expired", "count" => $expired],
                ["label" => "notexpired", "count" => $notexpired],
            ],
            "list" => $list,
        ];
    }
}
