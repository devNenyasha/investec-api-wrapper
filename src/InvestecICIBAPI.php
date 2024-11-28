<?php

namespace MelodyMbewe\InvestecApiWrapper;

use GuzzleHttp\Client as GuzzleClient;

class InvestecICIBAPI
{
    private $client;
    private $accessToken;
    private $apiEndpoint;
    private $apiKey;

    public function __construct($accessToken, $apiEndpoint, $apiKey)
    {
        $this->accessToken = $accessToken;
        $this->apiEndpoint = rtrim($apiEndpoint, '/');
        $this->apiKey = $apiKey;
        
        $baseUri = preg_replace('#/za/icib/v1$#', '', $this->apiEndpoint);
        $this->client = new GuzzleClient([
            'base_uri' => $baseUri,
            'verify' => false,
            'headers' => [
                'Authorization' => 'Bearer ' . $this->accessToken,
                'Accept' => 'application/json',
                'x-api-key' => $this->apiKey
            ]
        ]);
    }

    public function getAccounts()
    {
        try {
            $response = $this->client->get('/za/icib/v1/accounts');
            return json_decode($response->getBody()->getContents(), true);
        } catch (\Exception $e) {
            throw new \RuntimeException('Failed to get ICIB accounts: ' . $e->getMessage());
        }
    }

    public function getBalance($accountId)
    {
        try {
            $response = $this->client->get("/za/icib/v1/accounts/{$accountId}/balance");
            return json_decode($response->getBody()->getContents(), true);
        } catch (\Exception $e) {
            throw new \RuntimeException('Failed to get ICIB balance: ' . $e->getMessage());
        }
    }

    public function getTransactions($accountId, $fromDate = null, $toDate = null)
    {
        $endpoint = "/za/icib/v1/accounts/{$accountId}/transactions";
        $params = [];
        
        if ($fromDate) {
            $params['query']['fromDate'] = $fromDate;
        }
        
        if ($toDate) {
            $params['query']['toDate'] = $toDate;
        }

        try {
            $response = $this->client->get($endpoint, $params);
            return json_decode($response->getBody()->getContents(), true);
        } catch (\Exception $e) {
            throw new \RuntimeException('Failed to get ICIB transactions: ' . $e->getMessage());
        }
    }
}
