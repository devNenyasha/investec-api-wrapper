<?php

namespace MelodyMbewe\InvestecApiWrapper;

use MelodyMbewe\InvestecApiWrapper\InvestecOAuth;
use MelodyMbewe\InvestecApiWrapper\InvestecPrivateBankingAPI;
use MelodyMbewe\InvestecApiWrapper\InvestecICIBAPI;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\RequestException;

/**
 * Main client class for interacting with Investec APIs
 * 
 * @package MelodyMbewe\InvestecApiWrapper
 */
class Client
{
    private $oauth;
    private $privateBankingApi;
    private $icibApi;
    private $privateBankingApiEndpoint;
    private $icibApiEndpoint;
    private $apiKey;

    public function __construct(
        string $clientId,
        string $clientSecret,
        string $apiKey,
        string $privateBankingApiEndpoint,
        string $icibApiEndpoint,
        ?InvestecOAuth $oauth = null
    ) {
        $this->apiKey = $apiKey;
        $this->privateBankingApiEndpoint = $privateBankingApiEndpoint;
        $this->icibApiEndpoint = $icibApiEndpoint;
        
        $this->oauth = $oauth ?? new InvestecOAuth($clientId, $clientSecret, $apiKey);
        $this->initializeAPIs();
    }

    private function initializeAPIs()
    {
        $accessToken = $this->oauth->getAccessTokenUsingClientCredentials();
        $this->privateBankingApi = new InvestecPrivateBankingAPI(
            $accessToken, 
            $this->privateBankingApiEndpoint,
            $this->apiKey
        );
        $this->icibApi = new InvestecICIBAPI(
            $accessToken, 
            $this->icibApiEndpoint,
            $this->apiKey
        );
    }

    private function handleApiCall(callable $apiCall)
    {
        try {
            return $apiCall();
        } catch (RequestException $e) {
            if ($e->getResponse() && $e->getResponse()->getStatusCode() === 401) {
                // Token expired, refresh and retry
                $this->initializeAPIs();
                return $apiCall();
            }
            throw $e;
        }
    }

    public function checkServerConnection($url)
    {
        try {
            $client = new GuzzleClient(['verify' => false]);
            $response = $client->get($url);
            return $response->getStatusCode() === 200;
        } catch (\Exception $e) {
            return false;
        }
    }

    // Private Banking Methods with auto-refresh
    public function getPrivateBankingAccounts()
    {
        return $this->handleApiCall(fn() => $this->privateBankingApi->getAccounts());
    }

    public function getPrivateBankingBalance($accountId)
    {
        return $this->handleApiCall(fn() => $this->privateBankingApi->getBalance($accountId));
    }

    public function getPrivateBankingTransactions($accountId, $fromDate = null, $toDate = null)
    {
        return $this->handleApiCall(fn() => $this->privateBankingApi->getTransactions($accountId, $fromDate, $toDate));
    }

    // ICIB Methods with auto-refresh
    public function getICIBAccounts()
    {
        return $this->handleApiCall(fn() => $this->icibApi->getAccounts());
    }

    public function getICIBBalance($accountId)
    {
        return $this->handleApiCall(fn() => $this->icibApi->getBalance($accountId));
    }

    public function getICIBTransactions($accountId, $fromDate = null, $toDate = null)
    {
        return $this->handleApiCall(fn() => $this->icibApi->getTransactions($accountId, $fromDate, $toDate));
    }
}