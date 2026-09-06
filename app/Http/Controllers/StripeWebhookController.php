<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Notifications\PaymentFailedNotification;
use App\Notifications\PaymentSucceededNotification;
use App\Notifications\SubscriptionCancelledNotification;
use App\Notifications\WelcomeSubscriberNotification;
use Laravel\Cashier\Http\Controllers\WebhookController as CashierWebhookController;

class StripeWebhookController extends CashierWebhookController
{
    /**
     * Handle customer subscription updated event
     */
    protected function handleCustomerSubscriptionUpdated(array $payload)
    {
        $response = parent::handleCustomerSubscriptionUpdated($payload);

        $user = $this->getUserByStripeId($payload['data']['object']['customer']);

        if (! $user) {
            return $response;
        }

        $stripePrice = $payload['data']['object']['items']['data'][0]['price']['id'];

        $plan = Plan::where('stripe_price_id', $stripePrice)->first();

        if ($plan) {
            $user->forceFill([
                'plan_id' => $plan->id,
                'ai_credits' => $plan->ai_credits,
            ])->save();
        }

        return $response;
    }

    /**
     * Handle customer subscription deleted event
     */
    protected function handleCustomerSubscriptionDeleted(array $payload)
    {
        $response = parent::handleCustomerSubscriptionDeleted($payload);

        $user = $this->getUserByStripeId($payload['data']['object']['customer']);

        if (! $user) {
            return $response;
        }

        $basic = Plan::where('slug', 'basic')->first();

        if ($basic) {
            $user->forceFill([
                'plan_id' => $basic->id,
                'ai_credits' => $basic->ai_credits,
            ])->save();
            $user->notify(new SubscriptionCancelledNotification);
        }

        return $response;
    }

    /**
     * Handle invoice paid event
     */
    protected function handleInvoicePaid(array $payload)
    {
        $user = $this->getUserByStripeId($payload['data']['object']['customer']);

        if (! $user) {
            return $this->successMethod();
        }

        if ($user->plan) {
            $user->forceFill([
                'ai_credits' => $user->plan->ai_credits,
            ])->save();
            $user->notify(new PaymentSucceededNotification($user->plan->name));
        }

        return $this->successMethod();
    }

    /**
     * Handle customer subscription created event
     */
    protected function handleCustomerSubscriptionCreated(array $payload)
    {
        $response = parent::handleCustomerSubscriptionCreated($payload);

        $user = $this->getUserByStripeId($payload['data']['object']['customer']);

        if (! $user) {
            return $response;
        }

        $stripePrice = $payload['data']['object']['items']['data'][0]['price']['id'];

        $plan = Plan::where('stripe_price_id', $stripePrice)->first();

        if ($plan) {
            $user->forceFill([
                'plan_id' => $plan->id,
                'ai_credits' => $plan->ai_credits,
            ])->save();
            $user->notify(new WelcomeSubscriberNotification($plan->name));
        }

        return $response;
    }

    // Handle invoice payment failed event
    protected function handleInvoicePaymentFailed(array $payload)
    {
        $user = $this->getUserByStripeId($payload['data']['object']['customer']);

        if (! $user) {
            return $this->successMethod();
        }

        if ($user->plan) {
            $user->notify(
                new PaymentFailedNotification($user->plan->name)
            );
        }

        return $this->successMethod();
    }
}
