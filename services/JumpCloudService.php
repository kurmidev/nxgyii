<?php

namespace app\services;

use Yii;

class JumpCloudService
{
    private $apiUrl;
    private $apiKey;

    public function __construct()
    {
        $this->apiUrl = Yii::$app->params['thirdPartyApi']['baseUrl'];
        $this->apiKey = Yii::$app->params['thirdPartyApi']['apiKey'];
    }

    private function createClient()
    {
        return new \GuzzleHttp\Client([
            'headers' => [
                'x-api-key' =>  $this->apiKey,
                'Content-Type' => 'application/json',
                "x-org-id"=>"-"
            ],
        ]);
    }

    // Method to fetch data from the API
    public function fetchData($endpoint, $params = [])
    {
        $client = $this->createClient();

        try {
            $response = $client->request('GET', $this->apiUrl . $endpoint, [
                'query' => $params
            ]);

            $data = json_decode($response->getBody()->getContents(), true);
            return $data;
        } catch (\Exception $e) {
            print_r($e);
            Yii::error('API call failed: ' . $e->getMessage());
            return null;
        }
    }

    // Method to send data to the API
    public function sendData($endpoint, $data)
    {
        $client = $this->createClient();

        try {
            $response = $client->request('POST', $this->apiUrl . $endpoint, [
                'json' => $data
            ]);

            $responseData = json_decode($response->getBody()->getContents(), true);
            return $responseData;
        } catch (\Exception $e) {
            Yii::error('API call failed: ' . $e->getMessage());
            return null;
        }
    }

    public function getUsers(){
        $data = $this->fetchData("systemusers");
        $response = [
            "upcoming_password_expiring"=>[],
            "account_locked"=>[],
            "password_expired"=>[],
             "administrative_user"=>[],   
            "new_user_in7_days"=>[],
            "scheduled_user_suspension"=>[],
            "scheduled_user_activation"=>[],
            "user_totals"=>0
        ];
        if(!empty($data)){
            $response["user_totals"] = $data["totalCount"];
            foreach($data['results'] as $row){
                $passwordExpiredDate = date("Y-m-d",strtotime($row['password_date']));
                //password expiring
                if(strtotime($passwordExpiredDate)>=strtotime("-7 days")){
                    $response['upcoming_password_expiring'][] = $row;
                }

                if($row['account_locked']){
                    $response['locked_out_user'][] = $row;
                }   

                if($row['password_expired']){
                    $response['expired_user'][] = $row;
                }   

                if($row['sudo']){
                    $response['administrative_user'][] = $row;
                }   

                $createdAt = date("Y-m-d",strtotime($row['created']));
                //password expiring
                if(strtotime($createdAt)>=strtotime("-7 days")){
                    $response['new_user_in7_days'][] = $row;
                }
            }
        }
        return $response;
    }
}
