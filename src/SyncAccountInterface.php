<?php
namespace CeculaSyncApiClient;

interface SyncAccountInterface
{
    public function getCeculaBalance(): Object;

    public function getSubscriptionStatus(): Object;

    public function getSimStatus(string $msisdn): Object;

    public function refreshSIM(string $msisdn): Object;
}