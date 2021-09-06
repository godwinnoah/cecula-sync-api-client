<?php
namespace CeculaSyncApiClient;

interface SyncSmsInterface
{
    public function sendSMS(string $text, array $recipients): Object;

    public function getSentMessageStatus(string $smsTrackingId): Object;

    public function getUnreadSMS(): array;

    public function setSMSAutoResponseText(string $text): Object;
}