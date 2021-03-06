<?php

namespace CeculaSyncApiClient;

use phpDocumentor\Reflection\Types\Boolean;
use Requests;

class SyncAccount extends SyncApiClient implements SyncAccountInterface
{
    private float $minSmsCost = 2.5;


    /**
     * Get SIM MSISDN
     * This method exposes the mobile number behind and API Key
     *
     * @return object
     */
    public function getSimMSISDN(): object
    {
        $endpoint = sprintf("%s/%s", $this->apiManager->base, $this->apiManager->endpoints->account->msisdn->endpoint);
        $response = Requests::get($endpoint, $this->requestHeader);
        return json_decode($response->body);
    }

    /**
     * Balance is Insufficient
     * This method checks when balance is below the treshold for sending a single page message
     *
     * @return boolean
     */
    public function balanceIsInsufficient(): bool
    {
        return $this->getCeculaBalance() < $this->minSmsCost;
    }

    /**
     * Get Balance
     * Fetches the balance from your cecula account. In event of non-delivery of sms or calls, this method should be
     * used to confirm account balance.
     *
     * @return object {"balance": 2034.4}
     */
    public function getCeculaBalance(): object
    {
        $endpoint = sprintf("%s/%s", $this->apiManager->base, $this->apiManager->endpoints->account->getBalance->endpoint);
        $response = Requests::get($endpoint, $this->requestHeader);
        return json_decode($response->body);
    }

    /**
     * Subscription Status
     * This method could be used to detect the state of the subscription. States could be ACTIVE, INACTIVE, ...
     *
     * @return object {"subscriptionStatus": ACTIVE}
     */
    public function getSubscriptionStatus(): object
    {
        $endpoint = sprintf("%s/%s", $this->apiManager->base, $this->apiManager->endpoints->account->getSubscriptionStatus->endpoint);
        $response = Requests::get($endpoint, $this->requestHeader);
        return json_decode($response->body);
    }

    /**
     * SIM Status
     * This method returns the state of a SIM. Eg. READY, SENDING SMS, IN CALL, ...
     *
     * @param string $msisdn (optional) the target SIM
     * @return object The state of the SIM. e.g. READY
     */
    public function getSimStatus(string $msisdn=""): object
    {
        $endpoint = sprintf("%s/%s", $this->apiManager->base, $this->apiManager->endpoints->account->getSimStatus->endpoint);
        $response = Requests::get($endpoint, $this->requestHeader);
        return json_decode($response->body);
    }

    /**
     * Refresh SIM
     * This method refreshes the sim in event where messages are frozen.
     *
     * @param string $msisdn (optional) the target SIM
     * @return object {"status": "Successful"}
     */
    public function refreshSIM(string $msisdn=""): object
    {
        $endpoint = sprintf("%s/%s", $this->apiManager->base, $this->apiManager->endpoints->account->refreshSim->endpoint);
        $response = Requests::get($endpoint, $this->requestHeader);
        return json_decode($response->body);
    }
}