<?php
namespace CeculaSyncApiClient;

interface SyncAccountInterface
{
    public function getCeculaBalance(): Object;

    public function getSimMSISDN(): Object;

    public function getSubscriptionStatus(): Object;

    public function getSimStatus(string $msisdn): Object;

    public function refreshSIM(string $msisdn): Object;

    public function setDynamicWebhook(string $url, string $clientMsisdn, string $verificationType, int $validityPeriod): Object;
}