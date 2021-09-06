<?php

namespace CeculaSyncApiClient;

use Requests;

class APIManager
{
    private static APIManager $obj;
    public string $endpointData;
    private static string $endpointsRegister = "endpoints.json";


    private function __construct()
    {
        // Load Configuration
        $this->loadAPIConfig();

        // Check when last the registry was updated. 
        // If registry file has not been updated in the last 24 hours update the file
        if (!file_exists(__DIR__."/../".self::$endpointsRegister)) {
            self::updateEndpointsRegistry($this->endpointData);
        } else {
            // Auto Update Register
            $this->runAutoUpdate();
        }
    }

    /**
     * @return APIManager
     */
    public static function getInstance(): APIManager
    {
        if (!isset(self::$obj)) {
            self::$obj = new APIManager();
        } 
        return self::$obj;
    }


    /**
     * Run Auto-Update
     * This method is invoked on class load to check for updates to API and effect the changes on client.
     *
     * @return void
     */
    private function runAutoUpdate(): void
    {
        $localData = json_decode($this->endpointData);

            // Disable last update check if last check time is not registered
            if (empty($localData->lastUpdateCheck) || !is_numeric($localData->lastUpdateCheck)) {
                $localData->lastUpdateCheck = time() - (10 + $localData->updateInterval);
            }

            if ((time() - filemtime(__DIR__."/../".self::$endpointsRegister) > $localData->updateInterval) && (time() - $localData->lastUpdateCheck > $localData->updateInterval)) {
                $remoteDataString = $this->getEndpointsFromRegistry();
                $remoteData = json_decode($remoteDataString);
                if ($localData->version == $remoteData->version) {
                    $localData->lastUpdateCheck = time();
                    self::updateEndpointsRegistry($this->endpointData);
                } else {
                    self::updateEndpointsRegistry($remoteDataString);
                    $this->updateEndpointData($remoteDataString);
                }
            }
    }

    /**
     * Load API Configuration
     * This method checks if API Configuration file exists on client. If file is not found, it reads configuration
     * from the API Server.
     *
     * @return void
     */
    private function loadAPIConfig(): void
    {
        // Load endpoints from the remote register if the local version is not found.
            $this->endpointData = file_exists(__DIR__."/../".self::$endpointsRegister) ? file_get_contents(__DIR__."/../".self::$endpointsRegister) : $this->getEndpointsFromRegistry();
    }


    /**
     * Get Endpoints From Registry
     * This method reads endpoints from the API server
     *
     * @return string
     */
    private function getEndpointsFromRegistry(): string
    {
        $endpointData = !is_null($this->endpointData) ? json_decode($this->endpointData) : json_decode("");
        $serviceConfig = Requests::get($endpointData->serviceAPIs ?? "https://cecula.com/sync/api/endpoints.json");
        return $serviceConfig->body;
    }


    /**
     * Update Endpoint Registry
     * This method is used to update the local endpoint registry with values from the remote server.
     *
     * @param string $newData A JSON string of the API endpoints
     * @return void
     */
    private static function updateEndpointsRegistry(string $newData): void
    {
        file_put_contents(__DIR__."/../".self::$endpointsRegister, $newData);
    }

    /**
     * Update Endpoint Data
     * A setter for loading the endpoints into memory.
     *
     * @param string $data  A JSON string of the API endpoints
     * @return void
     */
    public function updateEndpointData(string $data): void
    {
        $this->endpointData = $data;
    }


    /**
     * Get Endpoint Data
     * A getter method for loading the API endpoints
     *
     * @return string
     */
    public function getEndpointData(): string
    {
        return $this->endpointData;
    }
}