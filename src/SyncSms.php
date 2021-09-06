<?php

namespace CeculaSyncApiClient;

use Requests;

class SyncSms extends SyncApiClient implements SyncSmsInterface
{
    /**
     * Send SMS
     * This method sends sms using the Cecula Sync API.
     *
     * @param string $text       Message body
     * @param array $recipients  An indexed array of recipients. eg. ["23480xxxxxxx","23490xxxxxxxx",...]
     * @return object            A JSON object
     */
    public function sendSMS(string $text, array $recipients): object
    {
        $endpoint = sprintf("%s/%s", $this->apiManager->base, $this->apiManager->endpoints->sms->sendSms->endpoint);
        $data = [
            "text" => $text,
            "recipients" => implode(",", $recipients)
        ];
        $response = Requests::post($endpoint, $this->requestHeader, json_encode($data));
        return json_decode($response->body);
    }

    /**
     * Get Sent SMS Status
     * When sendSMS() method is called successfully, a trackingId was generated for each of the recipients. This method
     * uses the trackingId returned to track the message status for a recipient.
     *
     * @param string $smsTrackingId
     * @return object
     */
    public function getSentMessageStatus(string $smsTrackingId): object
    {
        $endpoint = sprintf("%s/%s/%s", $this->apiManager->base, $this->apiManager->endpoints->sms->sentSmsStatus->endpoint, $smsTrackingId);
        $response = Requests::get($endpoint, $this->requestHeader);
        return json_decode($response->body);
    }

    /**
     * Get Unread SMS
     * This method fetches the list of Unread SMS messages
     *
     * @return array
     */
    public function getUnreadSMS(): array
    {
        $endpoint = sprintf("%s/%s", $this->apiManager->base, $this->apiManager->endpoints->sms->unreadSms->endpoint);
        $response = Requests::get($endpoint, $this->requestHeader);
        return json_decode($response->body);
    }

    /**
     * Set Auto-Response SMS
     * This method will set an automated reply sms to send when your hosted sim receives an sms.
     *
     * @param string $text An auto-response reply for incoming sms
     * @return object
     */
    public function setSMSAutoResponseText(string $text): object
    {
        $endpoint = sprintf("%s/%s", $this->apiManager->base, $this->apiManager->endpoints->sms->setAutoResponse->endpoint);
        $data = [
            "text" => $text
        ];
        $response = Requests::patch($endpoint, $this->requestHeader, json_encode($data));
        return json_decode($response->body);
    }
}