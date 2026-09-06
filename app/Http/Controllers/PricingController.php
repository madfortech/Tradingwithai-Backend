<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Services\UniqueKeyService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PricingController extends Controller
{
    public function index(Request $request)
    {

    if ($request->user()->hasRole('Admin')) {
            $plans = Plan::all();
        } else {
            $plans = Plan::where('is_active', true)->get();
        }

        $subscription = $request->user()->subscription('default');
        $currentPlan = null;
        $nextBilling = null;

        // if ($subscription) {
        //     $currentPlan = Plan::where(
        //         'stripe_price_id',
        //         $subscription->stripe_price
        //     )->first();

        //     $stripeSubscription = $subscription->asStripeSubscription();

        //     if (
        //         $stripeSubscription &&
        //         isset($stripeSubscription->items->data[0]->current_period_end)
        //     ) {
        //         $nextBilling = \Carbon\Carbon::createFromTimestamp(
        //             $stripeSubscription->items->data[0]->current_period_end
        //         );
        //     }
        // }

        if ($subscription) {
            $currentPlan = Plan::where(
                'stripe_price_id',
                $subscription->stripe_price
            )->first();

            // Sync database plan with active Stripe subscription
            if ($currentPlan && $request->user()->plan_id !== $currentPlan->id) {
                $request->user()->forceFill([
                    'plan_id' => $currentPlan->id,
                    'ai_credits' => $currentPlan->ai_credits,
                    'daily_ai_credits_used' => 0,
                    'credits_reset_at' => now()->addMonth(),
                    'daily_reset_at' => now()->addDay(),
                ])->save();

                $request->user()->refresh();
            }

            try {
                $stripeSubscription = $subscription->asStripeSubscription();

                if (
                    $stripeSubscription &&
                    isset($stripeSubscription->items->data[0]->current_period_end)
                ) {
                    $nextBilling = Carbon::createFromTimestamp(
                        $stripeSubscription->items->data[0]->current_period_end
                    );
                }
            } catch (\Exception $e) {
                // If Stripe API call fails, continue without next billing date
                $nextBilling = null;
            }
        }

        return view('pricing.index', [
            'plans' => $plans,
            'subscription' => $subscription,
            'currentPlan' => $currentPlan,
            'nextBilling' => $nextBilling,
        ]);
    }

    public function activateFreePlan(Request $request, Plan $plan, UniqueKeyService $uniqueKeyService)
    {
        if ($plan->price > 0) {
            abort(403);
        }

        $user = $request->user();

        if ($user->subscribed('default')) {

            return redirect()
                ->route('pricing')
                ->with('error', 'Please cancel your Pro subscription before switching to the Free plan.');
        }

        $user->update([
            'plan_id' => $plan->id,

            // Monthly credits
            'ai_credits' => $plan->ai_credits,

            // Daily usage reset
            'daily_ai_credits_used' => 0,

            // Next monthly reset
            'credits_reset_at' => now()->addMonth(),

            // Next daily reset
            'daily_reset_at' => now()->addDay(),
        ]);

        $plainKey = $uniqueKeyService->ensure($user->id);

        return redirect()
            ->route('pricing')
            ->with('success', 'Free plan activated successfully.');
    }
}
