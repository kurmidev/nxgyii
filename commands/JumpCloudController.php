<?php

namespace app\commands;

use app\models\ProductMaster;
use app\services\FetchData;
use Exception;
use Yii;

class JumpCloudController extends ConsoleController
{

    use FetchData;
    public $apiObject;

    const DEFAULT_PAGE_SIZE = 100;

    public function __construct($id, $module, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->cron_name = "JumpCloud Sync Users";
        $this->apiObject = ProductMaster::getProductObjects()['JUMPCLOUD'];
    }

    public function actionSyncData()
    {
        $apiList = $this->apiObject::$endPoints;

        foreach ($apiList as $model => $endPoints) {
            $skip = 0;
            $remaingCount = 0;
            do {
                if ($remaingCount <= 0 && $skip != 0) {
                    break;
                }
                $remaingCount = $this->fetchAndSave($endPoints, $model, $skip, $remaingCount);
                $skip++;
                echo "remaingCount => {$remaingCount} and skipCount => {$skip}" . PHP_EOL;
            } while ($remaingCount > 0);
        }
    }

    private function fetchAndSave($endPoints, $model, $skip = 0, $remaingCount = 0)
    {
        $isDelete = false;
        $headers = [
            'x-api-key' => Yii::$app->params['thirdPartyApi']['apiKey'],
            'Content-Type' => 'application/json',
        ];
        if (!(str_contains($endPoints, "/v2/software/catalog") || str_contains($endPoints, "/organizations"))) {
            $headers["x-org-id"] = "-";
        }
        $remaingCount = $remaingCount == 0 ? $skip * self::DEFAULT_PAGE_SIZE : $remaingCount;
       echo  $endpoint = $this->apiObject::$baseUrl . $endPoints . (str_contains($endPoints, "?") ? "&" : "?") . "skip=" . $skip;
    
        $data = $this->getData($endpoint, "GET", $headers);
        if (!isset($data["body"]["totalCount"]) && $skip == 0) {
            $data["body"]["totalCount"] = 10000;// count($data["body"]);
        }
        if ($remaingCount == 0 && $data["body"]["totalCount"] > 0 && $skip == 0) {
            $remaingCount = $data["body"]["totalCount"];
            $isDelete = true;
        }
        $records = !empty($data["body"]["results"]) ? $data["body"]["results"] :
            (!empty($data['body']['resources']) ? $data['body']['resources'] :
                (!empty($data['body']) ? $data['body'] : []));
        if (!empty($records)) {
            unset($records['totalCount']);
            $savedCount = $this->saveData($records, $model, $isDelete,$remaingCount);
            $remaingCount = $remaingCount - $savedCount;
        }
        return $remaingCount;
    }

    public function saveData($data, $model, $isDelete,$remaingCount)
    {
        $i = 0;
        $modelClass = "$model";
        if (!empty($data) && $isDelete) {
            echo "Deleting all data from $modelClass" . PHP_EOL;
            $modelClass::deleteAll(); // delete all data first before inserting new data.
        }
        echo "Inserting new data to $modelClass" . PHP_EOL;  // for testing purpose, comment out this line before production.
        //print_r($data);
        foreach ($data as $d) {
            
            if(empty($d) || $remaingCount<0){
                continue;
            }
            $remaingCount--;
            $i++;
            try {
                //¯$isExits = $modelClass::find()->where(['id' => $d['id']])->count();
                //if ($isExits==0) {
                $m = new $modelClass();
                $m->load($d, '');
                //print_r($m->getAttributes());
                if ($m->validate() && $m->save()) {
                  //  echo "Success saved to $modelClass" . PHP_EOL;
                } else {
                    print_r($m->errors);
                    exit;
                }
                // }else{
                //     echo "Skipped already exists data in $modelClass => {$d['id']}" . PHP_EOL;
                // }
            } catch (Exception $e) {
                print_r($e->getMessage());
                print_r($e->getLine());
                print_R($d);
                exit;
            }
        }
        return $i;
    }


}