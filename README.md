# Laravel 5 / Lumen 5 SparkPost Webhook Controller
[![Latest Version](https://img.shields.io/github/release/brentnd/laravel-sparkposthooks.svg?style=flat-square)](https://github.com/brentnd/laravel-sparkposthooks/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Total Downloads](https://img.shields.io/packagist/dt/brentnd/laravel-sparkposthooks.svg?style=flat-square)](https://packagist.org/packages/brentnd/laravel-sparkposthooks)

A simple SparkPost webhook controller to help with email events. Useful for notifying users that you cannot reach them via email inside your application. Compatible with Laravel 5+ and Lumen 5+.

## Installation
```composer require brentnd/laravel-sparkposthooks```

## Basic Usage

1) Create a controller that extends SparkPostWebhookController as follows. You can then handle any SparkPost webhook event.
```php
use Brentnd\Api\Webhooks\SparkPostWebhookController;

class MySparkPostController extends SparkPostWebhookController {

    /**
     * Handle a hard bounced email
     *
     * @param $payload
     */
    public function handleHardBounce($payload)
    {
        $email = $payload['msg']['email'];
    }

    /**
     * Handle a rejected email
     *
     * @param $payload
     */
    public function handleReject($payload)
    {
        $email = $payload['msg']['email'];
    }
}
```

2) Create the route to handle the webhook. In your routes.php file add the following.
```php
post('sparkpost-webhook', ['as' => 'sparkpost.webhook', 'uses' => 'MySparkPostController@handleWebHook']);
```
3) [Exclude your route from CSRF protection](https://laravel.com/docs/5.4/csrf#csrf-excluding-uris) so it will not fail.

4) Make sure you add your webhook in SparkPost to point to your route. You can do this here: TODO

## (Optional) Webhook Authentication
TODO: If you would like to increase the security of the webhooks. Add the *SparkPostWebhookServiceProvider* provider to the providers array in config/app.php

```php
'providers' => [
  ...
  Brentnd\Api\Webhooks\SparkPostWebhookServiceProvider::class,
],
```

Next, publish the configuration via
```php
php artisan vendor:publish --provider="Brentnd\Api\Webhooks\SparkPostWebhookServiceProvider"
```
Simply add your SparkPost webhook key in the config file and requests will be authenticated.

## Webhook Events
[Webhook event types](https://www.sparkpost.com/docs/tech-resources/webhook-event-reference/#event-types):

Event type              | Method             | Description
------------            |------------        |---------------
Sent	                | handleSend()       | message has been sent successfully
Bounced	                | handleHardBounce() | message has hard bounced
Opened	                | hadleOpen()        | recipient opened a message; will only occur when open tracking is enabled
Marked As Spam	        | handleSpam()       | recipient marked a message as spam
Rejected	            | handleReject()     | message was rejected
Delayed	                | handleDeferral()   | message has been sent, but the receiving server has indicated mail is being delivered too quickly and SparkPost should slow down sending temporarily
Soft-Bounced	        | handleSoftBounce() | message has soft bounced
Clicked	                | handleClick()      | recipient clicked a link in a message; will only occur when click tracking is enabled
Recipient Unsubscribes  | handleUnsub()      | recipient unsubscribes
Rejection Blacklist Changes	| handleBlacklist()  | triggered when a Rejection Blacklist entry is added, changed, or removed
Rejection Whitelist Changes	| handleWhitelist()  | triggered when a Rejection Whitelist entry is added or removed

## Contributors
Based on eventhomes/laravel-mandrillhooks
