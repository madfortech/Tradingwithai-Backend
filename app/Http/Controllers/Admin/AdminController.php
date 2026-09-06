<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Laravel\Cashier\Subscription;
use Carbon\Carbon;

class AdminController extends Controller
{
    
    // public function index()
    // {
    //     $totalUsers = User::count();

    //     $totalSubscriptions = Subscription::where('stripe_status', 'active')->count();

    //     $totalCancellingSubscriptions = Subscription::whereNotNull('ends_at')
    //         ->where('ends_at', '>', now())
    //         ->count();

    //     return view('admin.index', compact(
    //         'totalUsers',
    //         'totalSubscriptions',
    //         'totalCancellingSubscriptions'
    //     ));
    // }


    public function index()
    {
        $totalUsers = User::count();

        $totalSubscriptions = Subscription::count();

        $totalActiveSubscriptions = Subscription::where('stripe_status', 'active')
            ->whereNull('ends_at')
            ->count();

        $totalCancellingSubscriptions = Subscription::whereNotNull('ends_at')
            ->where('ends_at', '>', now())
            ->count();

        $totalRenewSubscriptions = Subscription::where('stripe_status', 'active')
            ->whereNull('ends_at')
            ->count();

        return view('admin.index', compact(
            'totalUsers',
            'totalSubscriptions',
            'totalActiveSubscriptions',
            'totalCancellingSubscriptions',
            'totalRenewSubscriptions'
        ));
    }

    public function users()
    {
        $users = User::latest()->paginate(10);

        return view('admin.users', compact('users'));
    }

    public function subscribers()
    {
        $subscribers = User::whereHas('subscriptions', function ($query) {
            $query->where('stripe_status', 'active');
        })->latest()->paginate(10);

        return view('admin.subscribers', compact('subscribers'));
    }

    public function cancellingSubscribers()
    {
        $subscribers = User::whereHas('subscriptions', function ($query) {
            $query->whereNotNull('ends_at')
                ->where('ends_at', '>', now());
        })
        ->latest()
        ->paginate(10);

        return view('admin.cancelling-subscribers', compact('subscribers'));
    }

    public function invoiceList()
    {
        $users = User::whereNotNull('stripe_id')
            ->orderBy('name')
            ->paginate(20);

        return view('admin.invoice-list', compact('users'));
    }

    public function showInvoices(User $user)
    {
        $invoices = $user->invoices();

        return view('admin.invoice-show', compact('user', 'invoices'));
    }

    public function downloadInvoice(User $user, string $invoice)
    {
        return $user->downloadInvoice($invoice, [
            'vendor' => config('app.name'),
            'product' => 'Subscription',
        ]);
    }
}
