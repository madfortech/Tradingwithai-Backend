<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Services\UniqueKeyService;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function checkout(Request $request, Plan $plan)
    {
        if (! $plan->stripe_price_id) {
            return back()->with('error', 'This plan is not available for purchase.');
        }

        // Store plan_id in session for immediate use after checkout
        session(['checkout_plan_id' => $plan->id]);

        return $request->user()
            ->newSubscription('default', $plan->stripe_price_id)
            ->checkout([
                'success_url' => route('checkout.success'),
                'cancel_url' => route('checkout.cancel'),

                // Required for Indian Stripe accounts
                'billing_address_collection' => 'required',

                'customer_update' => [
                    'name' => 'auto',
                    'address' => 'auto',
                ],

                'client_reference_id' => $request->user()->id,

                'metadata' => [
                    'plan_id' => $plan->id,
                ],
            ]);
    }

    public function success(Request $request, UniqueKeyService $uniqueKeyService)
    {
        $user = $request->user();

        // Get plan_id from session (set during checkout)
        $planId = session('checkout_plan_id');

        if ($planId) {
            $plan = Plan::find($planId);

            if ($plan) {
                $user->forceFill([
                    'plan_id' => $plan->id,
                    'ai_credits' => $plan->ai_credits,
                    'daily_ai_credits_used' => 0,
                    'credits_reset_at' => now()->addMonth(),
                    'daily_reset_at' => now()->addDay(),
                ])->save();
            }

            // Clear the session
            session()->forget('checkout_plan_id');
        }

        // Also try to sync with subscription if it exists
        $subscription = $user->subscription('default');

        if ($subscription) {
            $plan = Plan::where('stripe_price_id', $subscription->stripe_price)->first();

            if ($plan) {
                $user->forceFill([
                    'plan_id' => $plan->id,
                    'ai_credits' => $plan->ai_credits,
                    'daily_ai_credits_used' => 0,
                    'credits_reset_at' => now()->addMonth(),
                    'daily_reset_at' => now()->addDay(),
                ])->save();
            }
        }

        $plainKey = $uniqueKeyService->ensure($user->id);

        return redirect()
            ->route('pricing')
            ->with('success', 'Subscription activated successfully.')
            ->with('plain_key', $plainKey);
    }

    public function cancel()
    {
        return redirect()
            ->route('pricing')
            ->with('error', 'Payment cancelled.');
    }
}
