<?php
namespace CeculaSyncApiClient;

interface SyncCallInterface
{
    public function dial(string $receiver): Object;

    public function getCallStatus(string $callTrackingId): Object;

    public function getNewMissedCalls(): array;

    public function saveCallAutoResponseText(string $text): Object;
}