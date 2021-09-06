<?php

namespace CeculaSyncApiClient;

use Requests;


class SyncCall extends SyncApiClient implements SyncCallInterface
{

    /**
     * Dial Number
     * This method dials the supplied mobile phone number
     *
     * @param string $receiver Mobile number of recipient prefixed with country code.
     * @return object
     */
    public function dial(string $receiver): object
    {
        $endpoint = sprintf("%s/%s", $this->apiManager->base, $this->apiManager->endpoints->call->dial->endpoint);
        $data = [
            "receiver" => $receiver
        ];
        $response = Requests::post($endpoint, $this->requestHeader, json_encode($data));
        return json_decode($response->body);
    }

    /**
     * Get Call Status
     * This method uses the trackingID returned by the dial() method to fetch the status of a call.
     *
     * @param string $callTrackingId The tracking ID that was returned when call request by sendMissedCall()
     * @return object
     */
    public function getCallStatus(string $callTrackingId): object
    {
        $endpoint = sprintf("%s/%s/%s", $this->apiManager->base, $this->apiManager->endpoints->call->dialledCallStatus->endpoint, $callTrackingId);
        $response = Requests::get($endpoint, $this->requestHeader);
        return json_decode($response->body);
    }

    /**
     * Get New Missed CallS
     * This method fetches a collection of new missed calls.
     *
     * @return array
     */
    public function getNewMissedCalls(): array
    {
        $endpoint = sprintf("%s/%s", $this->apiManager->base, $this->apiManager->endpoints->call->newMissedCalls->endpoint);
        $response = Requests::get($endpoint, $this->requestHeader);
        return json_decode($response->body);
    }

    /**
     * Save Call Auto-Response Text
     * This method is used to set an auto-response message that should be sent to mobile phone number that attempts
     * to dial the hosted SIM.
     *
     * @param string $text A billable auto-response sms for callers
     * @return object
     */
    public function saveCallAutoResponseText(string $text): object
    {
        $endpoint = sprintf("%s/%s", $this->apiManager->base, $this->apiManager->endpoints->call->setAutoResponse->endpoint);
        $data = [
            "text" => $text
        ];
        $response = Requests::patch($endpoint, $this->requestHeader, json_encode($data));
        return json_decode($response->body);
    }
}