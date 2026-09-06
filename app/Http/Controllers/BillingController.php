<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BillingController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $subscription = $user->subscription('default');

        // Default: Last 3 Months
        $period = $request->get('period', '3');

        $invoices = collect($user->invoices())
            ->sortByDesc(fn ($invoice) => $invoice->date());

        $invoices = $invoices->filter(function ($invoice) use ($period) {
            return $invoice->date()->gte(
                now()->subMonths((int) $period)
            );
        })->values();

        return view('billing', [
            'subscription' => $subscription,
            'invoices' => $invoices,
            'period' => $period,
        ]);
    }

    public function download(Request $request, string $invoice)
    {
        return $request->user()->downloadInvoice(
            $invoice,
            [
                'vendor' => config('app.name'),
                'product' => 'AI SaaS Subscription',
            ]
        );
    }
}