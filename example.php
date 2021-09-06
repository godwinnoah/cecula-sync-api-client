<?php
require_once __DIR__."/vendor/autoload.php";

use CeculaSyncApiClient\SyncCall;
use CeculaSyncApiClient\SyncSms;
use CeculaSyncApiClient\SyncAccount;

$testMobile = ""; // Enter your mobile number here

// Testing Methods for Making Calls
$syncCall = new SyncCall();
echo "Send Missed Call: ".PHP_EOL;
var_dump($syncCall->dial($testMobile));
echo PHP_EOL;
echo PHP_EOL;
echo "Call Status: ".PHP_EOL;
var_dump($syncCall->getCallStatus("2020012676"));
echo PHP_EOL;
echo PHP_EOL;
echo "Call Auto-Response Message: ".PHP_EOL;
var_dump($syncCall->saveCallAutoResponseText(""));
echo PHP_EOL;
echo PHP_EOL;
echo "New Missed Calls: ".PHP_EOL;
var_dump($syncCall->getNewMissedCalls());
echo PHP_EOL;
echo PHP_EOL;


//Testing Methods for Sending SMS
$syncSms = new SyncSms();
echo "Send SMS: ".PHP_EOL;
var_dump($syncSms->sendSMS("Hello Sync", [$testMobile]));
echo PHP_EOL;
echo PHP_EOL;
echo "Sent SMS Status: ".PHP_EOL;
var_dump($syncSms->getSentMessageStatus("36545"));
echo PHP_EOL;
echo PHP_EOL;
echo "Get Unread SMS: ".PHP_EOL;
var_dump($syncSms->getUnreadSMS());
echo PHP_EOL;
echo PHP_EOL;
echo "Save Auto-Response SMS: ".PHP_EOL;
var_dump($syncSms->setSMSAutoResponseText("Thank you. I'll revert ASAP"));
echo PHP_EOL;
echo PHP_EOL;



//Testing Methods for Managing Account
$syncAccount = new SyncAccount();
echo "Get Cecula Balance: ".PHP_EOL;
var_dump($syncAccount->getCeculaBalance());
echo PHP_EOL;
echo PHP_EOL;
echo "Get Subscription Status: ".PHP_EOL;
var_dump($syncAccount->getSubscriptionStatus());
echo PHP_EOL;
echo PHP_EOL;
echo "Get SIM Status: ".PHP_EOL;
var_dump($syncAccount->getSimStatus());
echo PHP_EOL;
echo PHP_EOL;
echo "Refresh SIM: ".PHP_EOL;
var_dump($syncAccount->refreshSIM());
echo PHP_EOL;
echo PHP_EOL;