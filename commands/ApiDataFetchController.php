<?php

namespace app\commands;

use app\component\Constants;
use app\models\ProductCompanyMapping;
use app\models\ProductsApiList;
use app\services\FetchData;
use GuzzleHttp\Client;
use Yii;

class ApiDataFetchController extends ConsoleController
{
    use FetchData;
    const DEFAULT_PAGE_SIZE = 100;

    public function actionRun()
    {
        $model = ProductCompanyMapping::find()->active()->all();
        foreach ($model as $product) {
            $apiList = $this->getApiConfigs($product->product_id);
            if (!empty($apiList)) {
                $tokenKey = "token_{$product->company_id}_{$product->product_id}";
                $cacheToken = Yii::$app->cache->get($tokenKey);
                $loginDetails = !empty($cacheToken) ? $cacheToken : $this->getAuthorizationToken($product);
                // $loginDetails = [
                //     "status" => Constants::STATUS_ACTIVE,
                //     "data" => [
                //         "token" => "eyJhbGciOiJIUzUxMiIsInR5cCI6IkpXVCIsImtpZCI6ImNkYTYxOTYyLWYxYTEtNTc2Yi1hN2RkLWIwNDZjYTJmMGE2ZCJ9.eyJzZXNzaW9uX2lkIjoiMzYyZjQ2YTAtMjliNi0xMWYwLTg2NjEtYmQ4YmNlMmMyZTI1IiwiYmVhcmVyIjp7ImVtYWlsIjoiQXNoaXNoc3NodWtsYUBnbWFpbC5jb20iLCJ1aWQiOiJkOTI4ZjNiYi1iZDJkLTQ5MjctYTM2Yi0wZjk1N2RiNGM1MTMiLCJyb2xlIjozLCJtaWQiOiJlZGZkYWE2Yy0wZjQwLTQzM2EtOTYzOC1iMzI0OTBhYTIyYzgiLCJ0ZW5hbnRfaWQiOiJPVE1NYXN0ZXJUZW5hbnQiLCJkaXJfdHlwZSI6MCwiYWNsIjoiZUp3RndZRUJ3Q0FJQTdDWGhJcklPUlRraWgyL3hFMFh6MlVuVExVUzVlV1hVN29rdG9PTjJjeE9xcldLcEtrVjRLbG5kZUI4RGVtdHQzWndMUHRPQk8zSmpEdjVDajhqT1J0dyJ9LCJwYXlsb2FkIjoiMzYyZjQ2YTAtMjliNi0xMWYwLTg2NjEtYmQ4YmNlMmMyZTI1IiwiaWF0IjoxNzQ2NDUyMzAxLCJleHAiOjE3NDY0NTk1MDEsImF1ZCI6IjRlYTA3MmE2NWY5OGM4NWZkY2QyNDViYmUyZmE4Mzc1OTk5YmYwNjViYTczNWM2OTg5ZjUwNmY0OGJhNThjZjgiLCJpc3MiOiJiMjU3NDBmODYxN2NiYzc5ZDRmNzEyNmU2OTNjODFmNzM3NTFiYzVlODhlOWI5OGM0ZjE5MmJiZjliMDc2NThjIiwic3ViIjoiZjMxZTJkNTk4NDAwMjQwZGU1NjMzOTA2M2UxNzE0ODU5ZmM3ZmJlNjlhZmMwYzU1N2Q1MzEyMDcyOTFiNDE3NCJ9.zptfJie-rZ1l3KqR8hYCfeEtyvwooL3HAjJrJOZ2FLTA7wjUeS69DUKAnwj7wc8NZaFbMNvAYyhfJELpIFxVAQ"
                //     ]
                // ];
                if ($loginDetails["status"] == Constants::STATUS_INACTIVE) {
                    Yii::$app->cache->delete('token_' . $product->id);
                    $loginDetails = $this->getAuthorizationToken($product);
                }
                if ($loginDetails['status'] == Constants::STATUS_ACTIVE) {
                    Yii::$app->cache->set($tokenKey, $loginDetails, 300);
                    $token = $loginDetails['data']['token'];
                    $config = [
                        'headers' => array_merge(
                            !empty($product->products->auth_headers)?$this->mergeKeyValue($product->products->auth_headers,'', $token):[],
                            !empty($product->headers)?$this->mergeKeyValue($product->headers, '',$token):[]
                        ),
                        'token' => $token,
                        "base_uri" => rtrim($product->products->base_url, '/'),
                        "company_id" => $product->company_id,
                    ];
                    $this->fetchAndSaveData($apiList, $config);
                }
            }
        }
    }

    private function mergeKeyValue($dataSets, $type = "", $token = "")
    {
        if (empty($dataSets)) {
            return [];
        }
        $resp = [];
        switch ($type) {
            case "url":
                $r = [];
                foreach ($dataSets as $ds) {
                    if (!empty($ds['key']) && !empty($ds['val'])) {
                        $r[] = $ds["key"] . "=" . $ds["val"];
                    }
                    $resp = implode("&", $r);
                }
                break;
            default:
                foreach ($dataSets as $ds) {
                    if (!empty($ds['key']) && !empty($ds['val'])) {
                        $val = $ds['val'];
                        if (str_contains($val, '<token>')) {
                            $val = str_replace('<token>', $token, $val);
                        }
                        $resp[$ds["key"]] = $val;
                    }
                }
                break;
        }
        return $resp;
    }

    private function getAuthorizationToken($product)
    {
        switch ($product->products->authentication_type) {
            case Constants::AUTH_TYPE_LOGIN:
                $headers = empty($product->products['login_headers']) ? [] : $product->products['login_headers'];
                $headers = $this->mergeKeyValue($headers);
                $body = $product->credentials;
                $url = rtrim($product->products->base_url, '/') . '/' . ltrim($product->products->login_endpoint, '/');
                $res = $this->getData($url, $method = "POST", $headers, $body);
                if (!empty($res)) {
                    $token = null;
                    if (!empty($res["body"]["response"][1]["jwttoken"])) {
                        $token = $res["body"]["response"][1]["jwttoken"];
                        return [
                            'status' => Constants::STATUS_ACTIVE,
                            'data' => [
                                'token' => $token
                            ]
                        ];
                    } else {
                        return [
                            'status' => Constants::STATUS_INACTIVE,
                            'data' => null
                        ];
                    }
                }
                break;
            case Constants::AUTH_TYPE_TOKEN:
                return [
                    'status' => Constants::STATUS_ACTIVE,
                    'data' => [
                        'token' => $product->credentials['token']
                    ]
                ];
            default:
                return [
                    'status' => Constants::STATUS_INACTIVE,
                    'data' => []
                ];
        }
    }

    private function getApiConfigs($product_id)
    {
        return ProductsApiList::find()->active()->andWhere(["product_id" => $product_id])->all();
    }

    private function fetchAndSaveData($apiList, $config)
    {
        foreach ($apiList as $api) {
            if ($api->is_pagination) {
                $this->fetchPaginatedApi($api, $config);
            } else {
                $this->fetchApi($api, $config);
            }
        }
    }

    private function fetchApi($api, $config = [])
    {
        $url = rtrim($config['base_uri'], '/') . '/' . ltrim($api['api_endpoint'], '/');
        if (!empty($api['api_params'])) {
            $url .= "?" . $this->mergeKeyValue($api["api_params"], "url");
        }
        $header = array_merge(
            $config['headers'],
            !empty($api['api_headers']) ? $this->mergeKeyValue($api['api_headers']) : []
        );
        // if (!empty($config['token'])) {
        //     $header['Authorization'] = "Bearer " . $config['token'];
        // }

        $params = !empty($api['api_body']) ?  $this->mergeKeyValue($api['api_body']) : [];
        $res = $this->getData($url, $api['api_method'], $header, $params);
        print_r([
            "header" => $header,
            "url" => $url,
            "res" => $res,
            "method" => $api['api_method']
        ]);
        $collectionName = strtolower(preg_replace('/[^a-z0-9_]/i', '_', $api['api_name'] . "_" . $api['id']));
        if ($res) {
            if (!empty($res["body"]["results"])) {
                $this->saveToMongoCollection($collectionName, $res["body"]["results"], $config);
            }
        }
    }

    private function fetchPaginatedApi($api, $config = [])
    {

        $collectionName = strtolower(preg_replace('/[^a-z0-9_]/i', '_', $api['api_name'] . "_" . $api['id']));

        $url = rtrim($config['base_uri'], '/') . '/' . ltrim($api['api_endpoint'], '/');
        if (!empty($api['api_params'])) {
            $url .= "?" . $this->mergeKeyValue($api["api_params"], "url");
        }

        $header = array_merge(
            $config['headers'],
            !empty($api['api_headers']) ? $this->mergeKeyValue($api['api_headers'],'',$config['token']) : []
        );

        $skip = 0;
        $remaingCount = 0;
        do {
            if ($remaingCount <= 0 && $skip != 0) {
                break;
            }
            $remaingCount = $this->fetchAndSavePagination($url, $header, $api['api_method'], $collectionName, $skip, $remaingCount, $config, $api['api_body']);
            $skip++;
            echo "remaingCount => {$remaingCount} and skipCount => {$skip}" . PHP_EOL;
        } while ($remaingCount > 0);

    }

    private function fetchAndSavePagination($url, $headers, $method, $collectionName, $skip, $remaingCount, $config = [], $params = [])
    {
        $remaingCount = $remaingCount == 0 ? $skip * self::DEFAULT_PAGE_SIZE : $remaingCount;
        $endpoint = $url;
    $endpoint .= (str_contains($url, "?") ? "&" : "?") . "skip=" . $skip;
        
        $data = $this->getData($endpoint, $method, $headers);
        print_r([
            "header" => $headers,
            "url" => $endpoint,
            "res" => $data,
            "method" => $method
        ]);

        if (!isset($data["body"]["totalCount"]) && $skip == 0) {
            $data["body"]["totalCount"] = 1000;// count($data["body"]);
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
            $savedCount = $this->saveToMongoCollection($collectionName, $records, $config);
            $remaingCount = $remaingCount - $savedCount;
        } else {
            $remaingCount = 0;
        }
        return $remaingCount;
    }

    private function saveToMongoCollection($collectionName, $data, $config)
    {
        $i = 0;
        $collection = Yii::$app->mongodb->getCollection($collectionName);
        $collection->remove(["company_id" => $config['company_id']]);
        foreach ($data as $d) {
            $fd = array_merge(
                $d,
                [
                    'fetched_at' => date("YmdHi"),
                    "company_id" => $config['company_id'],
                ]
            );
            $collection->insert($fd);
            $i++;
        }
        return $i;
    }

    private function logError($apiId, $message)
    {
        Yii::error("API ID: $apiId failed. Error: $message", 'apiFetch');
    }

}