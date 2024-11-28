<?php

namespace MelodyMbewe\InvestecApiWrapper;

use GuzzleHttp\Client as GuzzleClient;

class InvestecOAuth
{
    private $clientId;
    private $clientSecret;
    private $apiKey;
    private $accessToken;
    private $tokenExpiry;
    private $tokenEndpoint;

    public function __construct($clientId, $clientSecret, $apiKey, $tokenEndpoint = null)
    {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->apiKey = $apiKey;
        $this->tokenEndpoint = $tokenEndpoint ?? 'http://localhost:3000/identity/v2/oauth2/token';
    }

    public function getAccessTokenUsingClientCredentials()
    {
        if ($this->isTokenValid()) {
            return $this->accessToken;
        }

        $client = new GuzzleClient([
            'verify' => false,
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/x-www-form-urlencoded'
            ]
        ]);
        
        try {
            $response = $client->post($this->tokenEndpoint, [
                'headers' => [
                    'x-api-key' => $this->apiKey
                ],
                'auth' => [$this->clientId, $this->clientSecret],
                'form_params' => [
                    'grant_type' => 'client_credentials'
                ]
            ]);

            $data = json_decode($response->getBody()->getContents(), true);
            $this->accessToken = $data['access_token'];
            $this->tokenExpiry = time() + $data['expires_in'];
            
            return $this->accessToken;
        } catch (\Exception $e) {
            throw new \RuntimeException('Failed to get access token: ' . $e->getMessage());
        }
    }

    private function isTokenValid()
    {
        return $this->accessToken && $this->tokenExpiry && time() < $this->tokenExpiry;
    }
}