<?php
namespace CeculaSyncApiClient;

use Exception;

class SyncApiClient
{
    private static string $credentialSource = ".ceculasync.json";
    
    private object $credentials;

    protected object $apiManager;
    protected array $requestHeader;

    public function __construct()
    {
        $this->apiManager = json_decode(APIManager::getInstance()->getEndpointData());

        try {
            $this->credentials = json_decode($this->getCredentials());
        } catch (Exception $e) {
            printf("%s<br />%s", $e->getMessage(), $e->getCode());
        }

        $this->requestHeader = [
            'content-type' => 'application/json',
            'authorization' => sprintf("Bearer %s", $this->credentials->apiKey)
        ];


    }

    public function getCredentials(): string
    {
        $pathway = strstr(__DIR__, 'vendor/cecula/sync-api-client') ? "/../../../../" : "/../";
        if (!file_exists(__DIR__.$pathway.self::$credentialSource)) {
            throw new Exception("Credential File not found. Please create file .ceculasync.json at your application root folder. Kindly refer to readme file for guide.", 404);
        } else {
            return file_get_contents(__DIR__.$pathway.self::$credentialSource);
        }
    }
}