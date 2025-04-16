<?php

namespace app\component;

use app\services\FetchData;
use GuzzleHttp\Client;
use Yii;

class Zoho
{
    use FetchData;
    public $client;
    public $token;
    public $refreshToken;
    public $baseUrl = "https://desk.zoho.com/api/v1";

    public $headers;

    public function __construct()
    {
        $this->client = new Client();
        $this->generateTokens();
    }

    private function generateTokens()
    {
        $this->generateAuthToken();
        exit;
        $cachedRefreshToken = !empty(ZOHO_REFRESH_TOKEN)?ZOHO_REFRESH_TOKEN:Yii::$app->cache->get('zoho_refresh_token');
        echo "Cached Refresh tokens....{$cachedRefreshToken}" . PHP_EOL;

        if (!empty($cachedRefreshToken)) {
            $this->refreshToken = $this->generateRefreshToken($cachedRefreshToken);
        } else {
            echo "generating tokens.........." . PHP_EOL;
            $this->generateAuthToken();
        }
    }

    private function generateRefreshToken($refreshToken)
    {
        $params = [
            'grant_type' => 'refresh_token',
            'refresh_token' => $refreshToken,
            'client_id' => Yii::$app->params['zoho']["CLIENT_ID"],
            'client_secret' => Yii::$app->params['zoho']["CLIENT_SECRET"],
        ];
        print_r($refreshToken);
        $endPoint = "https://accounts.zoho.com/oauth/v2/token?refresh_token=$refreshToken&client_id=" . Yii::$app->params['zoho']["CLIENT_ID"] . "&client_secret=" . Yii::$app->params['zoho']["CLIENT_SECRET"] . "&scope=ZohoSupport.tickets.ALL&grant_type=refresh_token";
        echo $endPoint . PHP_EOL;
        $response = $this->getData($endPoint, "POST", []);
        echo "generating refresh token...." . PHP_EOL;
        if ($response["body"]['access_token']) {
            $this->token = $response["body"]['access_token'];
            $this->headers = [
                'Authorization' => "Zoho-oauthtoken " . $this->token,
                'orgId' => Yii::$app->params['zoho']['YOUR_ORG_ID'],
                'Content-Type' => 'application/json'
            ];
            echo "tokens generated successfully" . PHP_EOL;
        } else {
            echo "Error in generating tokens" . PHP_EOL;
            echo $response["body"]['error'] . "\n";
            echo $response["body"]['error_description'] . "\n";

        }
        return $response;

    }

    public function generateAuthToken()
    {
        $endpoint = "https://accounts.zoho.in/oauth/v2/token?code=" . Yii::$app->params['zoho']["CODE"] . "&grant_type=authorization_code&client_id=" . Yii::$app->params['zoho']["CLIENT_ID"] . "&client_secret=" . Yii::$app->params['zoho']["CLIENT_SECRET"];

        echo $endpoint . PHP_EOL;
        $response = $this->getData($endpoint, "POST");
        print_r($response);
        if (!empty($response['body']) && !empty($response['body']['access_token'])) {
            print_r($response['body']);
            $token = $response['body']['access_token'];
            $refreshToken = $response['body']['refresh_token'];
            Yii::$app->cache->set('zoho_token', $token,365*24*60*60);
            Yii::$app->cache->set('zoho_refresh_token', $refreshToken,365*24*60*60);

            $this->generateRefreshToken($this->refreshToken);
        }
    }

    public function createComplaint($params)
    {

        $endpoint = "{$this->baseUrl}/tickets";
        echo $endpoint . PHP_EOL;
        print_r($this->headers);
        print_r($params);
        $response = $this->getData($endpoint, "POST", $this->headers, $params);
        print_r($response);
        if(!empty($response['body']['id'])) {
            return $response['body']['id'];
        }
        return "";
    }

    public function updateReply($ticketId, $params)
    {
        $endpoint = "{$this->baseUrl}/tickets/{$ticketId}/comments";
        $response = $this->getData($endpoint, "POST", $this->headers, $params);
        print_r($response);
        if(!empty($response['body']['id'])) {
            return $response['body']['id'];
        }
        return "";
    }

    public function closeTicket($ticketId, $params)
    {
        $endpoint = "{$this->baseUrl}/tickets/{$ticketId}";
        $response = $this->getData($endpoint, "PUT", $this->headers, $params);
        print_r($response);
        if(!empty($response['body']['id'])) {
            return $response['body']['id'];
        }
        return $response;
    }
}