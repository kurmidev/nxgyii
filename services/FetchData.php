<?php
namespace app\services;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

trait FetchData{
    public function getData($endpoint,$method="GET",$headers=[], $params = []){
        try{
            $client = new Client();
            $params = !empty($params) ? json_encode($params) : "";
            $request = new Request($method, $endpoint, $headers,$params);
            $response = $client->send($request);
            if($response->getStatusCode() == 200){
                return ["body" => json_decode($response->getBody()->getContents(),true)];
            }else{
                return ["body" => []];
            }
        }catch(Exception $e){
            print_r($e->getMessage());
            return ["body" => []];
        }
    }
}