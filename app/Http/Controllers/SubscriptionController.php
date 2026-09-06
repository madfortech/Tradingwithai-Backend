<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function cancel(Request $request)
    {
        $user = $request->user();

        $user->subscription('default')->cancel();

        return back()->with('success', 'Your subscription has been cancelled.');
    }
}
