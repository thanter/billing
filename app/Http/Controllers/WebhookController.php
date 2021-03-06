<?php

namespace App\Http\Controllers;

use Braintree\WebhookNotification;
use Illuminate\Http\Request;

use Log;
use Illuminate\Http\Response;
use Laravel\Cashier\Http\Controllers\WebhookController as CashierController;

class WebhookController extends CashierController
{
    public function handleSubscriptionChargedSuccessfully(WebhookNotification $notification)
    {
        Log::info('charged successfully');
        Log::info($notification->subscription->id);

        return new Response('Webhook Handled', 200);
    }


    public function handleSubscriptionChargedUnsuccessfully(WebhookNotification $notification)
    {
        Log::info('charged failed');
        Log::info($notification->subscription->id);

        return new Response('Webhook Handled', 200);
    }


    public function handleSubscriptionWentActive(WebhookNotification $notification)
    {
        Log::info('went active');
        Log::info($notification->subscription->id);

        return new Response('Webhook Handled', 200);
    }


    /**
     * Handle a Braintree webhook.
     *
     * @param  WebhookNotification  $webhook
     * @return Response
     */
    public function handleDisputeOpened(WebhookNotification $notification)
    {
        // Handle The Event
    }
}
