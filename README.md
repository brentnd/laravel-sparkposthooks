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
     * Handle a bounced email
     *
     * @param $payload
     */
    public function handleMessageEventBounce($payload)
    {
        $email = $payload['rcpt_to'];
    }

    /**
     * Handle a rejected email
     *
     * @param $payload
     */
    public function handleMessageEventPolicyRejection($payload)
    {
        $email = $payload['rcpt_to'];
    }

    /**
     * Handle an email open
     *
     * @param $payload
     */
    public function handleTrackEventOpen($payload)
    {
        $transmissionId = $payload['transmission_id'];
    }
}
```

2) Create the route to handle the webhook. In your routes.php file add the following.
```php
post('sparkpost-webhook', ['as' => 'sparkpost.webhook', 'uses' => 'MySparkPostController@handleWebhook']);
```
3) [Exclude your route from CSRF protection](https://laravel.com/docs/5.4/csrf#csrf-excluding-uris) so it will not fail.

4) Make sure you add your webhook in SparkPost to point to your route. You can do this here: https://app.sparkpost.com/webhooks

## Webhook Events
[Webhook event types](https://www.sparkpost.com/docs/tech-resources/webhook-event-reference/#event-types):

Common events and their handlers. For other events, just follow the same pattern.

Event type         | Event             | Method  
-----------        |-------------      |-------
Ping               | -                 | handlePing()
Message Events     | Bounce            | handleMessageEventBounce()
Message Events     | Delivery          | handleMessageEventDelivery()
Message Events     | Injection         | handleMessageEventInjection()
Message Events     | Policy Rejection  | handleMessageEventPolicyRejection()
Message Events     | Delay             | handleMessageEventDelay()
Engagement Events  | Click             | handleTrackEventClick()
Engagement Events  | Open              | handleTrackEventOpen()
Engagement Events  | Initial Open      | handleTrackEventInitialOpen()
Unsubscribe Events | List Unsubscribe  | handleUnsubscribeEventListUnsubscribe()
Unsubscribe Events | Link Unsubscribe  | handleUnsubscribeEventLinkUnsubscribe()


## Contributors
Based on [eventhomes/laravel-mandrillhooks](https://github.com/eventhomes/laravel-mandrillhooks)
