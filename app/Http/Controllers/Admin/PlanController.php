<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Plan;

class PlanController extends Controller
{
    public function edit(Plan $plan)
    {
        return view('admin.plans.edit', compact('plan'));
    }


    public function update(Request $request, Plan $plan)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'ai_credits' => 'required|integer|min:0',
            'features' => 'nullable|string',

        ]);

        $features = collect(explode("\n", $request->features))
            ->map(fn($line) => trim($line))
            ->filter()
            ->values()
            ->toArray();

        $plan->update([
            'name' => $validated['name'],
            'price' => $validated['price'],
            'ai_credits' => $validated['ai_credits'],
            'features' => $features,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()
            ->route('plans.edit', $plan)
            ->with('success', 'Plan updated successfully.');
    }

    
}
