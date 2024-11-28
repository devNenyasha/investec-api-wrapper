<?php

namespace MelodyMbewe\InvestecApiWrapper;

use GuzzleHttp\Client as GuzzleClient;

class InvestecPrivateBankingAPI
{
    private $client;
    private $accessToken;
    private $apiEndpoint;

    public function __construct($accessToken, $apiEndpoint)
    {
        $this->accessToken = $accessToken;
        $this->apiEndpoint = rtrim($apiEndpoint, '/');
        $this->client = new GuzzleClient([
            'base_uri' => $this->apiEndpoint,
            'headers' => [
                'Authorization' => 'Bearer ' . $accessToken,
                'Accept' => 'application/json'
            ]
        ]);
    }

    public function getAccounts()
    {
        try {
            $response = $this->client->get('/za/pb/v1/accounts');
            $data = json_decode($response->getBody()->getContents(), true);
            
            if (empty($data['data']['accounts'])) {
                throw new \RuntimeException('No accounts found in the response');
            }
            
            return $data;
        } catch (\Exception $e) {
            throw new \RuntimeException('Failed to get accounts: ' . $e->getMessage());
        }
    }

    public function getBalance($accountId)
    {
        if (!$accountId) {
            throw new \InvalidArgumentException('Account ID is required');
        }

        try {
            $response = $this->client->get("/za/pb/v1/accounts/{$accountId}/balance");
            return json_decode($response->getBody()->getContents(), true);
        } catch (\Exception $e) {
            throw new \RuntimeException("Failed to get balance for account {$accountId}: " . $e->getMessage());
        }
    }

    public function getTransactions($accountId, $fromDate, $toDate = null)
    {
        $endpoint = "/za/pb/v1/accounts/{$accountId}/transactions";
        $query = ['fromDate' => $fromDate];
        
        if ($toDate) {
            $query['toDate'] = $toDate;
        }
        
        try {
            $response = $this->client->get($endpoint, [
                'query' => $query
            ]);
            return json_decode($response->getBody()->getContents(), true);
        } catch (\Exception $e) {
            throw new \RuntimeException('Failed to get transactions: ' . $e->getMessage());
        }
    }

    public function transfer($fromAccountId, $transfer)
    {
        $response = $this->client->post("accounts/$fromAccountId/transfers", ['json' => $transfer]);
        return json_decode($response->getBody()->getContents(), true);
    }
}