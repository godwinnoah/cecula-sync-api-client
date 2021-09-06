# Introduction

Cecula Sync API Client is a simple library that powers your app to manage your hosted
sim account. You can access all endpoint features simply by invoking the appropriate 
methods for making calls, sending sms, etc.


## Installation

I'll take it for granted that you're already using composer. To install Cecula Sync API
Client to your project simply run the command below in your terminal.

~~~
composer require cecula/sync-api-client
~~~

#### Get your API Key
* Login to the [Cecula Sync Platform](https://cecula.com/sync/pf)
* Navigate to **Account > Settings** Select the **API Key** tab, generate new key if you do not already have one
* Copy the key

#### Create your Config File
* Run the following command on your terminal. Change /path/to/project to your project 
directory
~~~
cd /path/to/project
cp vendor/cecula/sync-api-client/.ceculasync.json.example .ceculasync.json
~~~
* Open .ceculasync.json file and paste your API Key in the appropriate field. 

And that's all! Let's jump right into action with a quick start.

## Quick Start

Since we are working with composer, I am trusting somewhere in your project you have 
already autoloaded classes. Cecula Sync API Client will autoload if you have done something
like this at least in your entry script.
~~~
require_once __DIR__."/vendor/autoload.php";
~~~
*** If you are using a framework, that would have already been done for you.

#### Calls
~~~
$testMobile = ""; // Enter your mobile number here

// Testing Methods for Making Calls
$syncCall = new SyncCall();

echo "Send Missed Call: ".PHP_EOL;
var_dump($syncCall->dial($testMobile));

echo "Call Status: ".PHP_EOL;
var_dump($syncCall->getCallStatus("2020012676"));

echo "Call Auto-Response Message: ".PHP_EOL;
var_dump($syncCall->saveCallAutoResponseText(""));

echo "New Missed Calls: ".PHP_EOL;
var_dump($syncCall->getNewMissedCalls());
~~~

#### SMS
~~~
$syncSms = new SyncSms();
echo "Send SMS: ".PHP_EOL;
var_dump($syncSms->sendSMS("Hello Sync", [$testMobile]));

echo "Sent SMS Status: ".PHP_EOL;
var_dump($syncSms->getSentMessageStatus("36545"));

echo "Get Unread SMS: ".PHP_EOL;
var_dump($syncSms->getUnreadSMS());

echo "Save Auto-Response SMS: ".PHP_EOL;
var_dump($syncSms->setSMSAutoResponseText("Thank you. I'll revert ASAP"));
~~~

#### Account Management
~~~
$syncAccount = new SyncAccount();

echo "Get Cecula Balance: ".PHP_EOL;
var_dump($syncAccount->getCeculaBalance());

echo "Get Subscription Status: ".PHP_EOL;
var_dump($syncAccount->getSubscriptionStatus());

echo "Get SIM Status: ".PHP_EOL;
var_dump($syncAccount->getSimStatus());

echo "Refresh SIM: ".PHP_EOL;
var_dump($syncAccount->refreshSIM());
~~~

For more details, kindly refer to the [Cecula Sync API Reference](https://api-reference.cecula.com).