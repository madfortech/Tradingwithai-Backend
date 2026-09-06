<x-app-layout>

    @include('sidebar.side')
@php
    $total = auth()->user()->plan?->ai_credits ?? 0;
    $remaining = auth()->user()->ai_credits ?? 0;
    $percentage = $total > 0 ? round(($remaining / $total) * 100) : 0;
    $dailyLimit = auth()->user()->plan?->daily_ai_credit_limit ?? 0;
    $dailyUsed = auth()->user()->daily_ai_credits_used ?? 0;
    $dailyRemaining = max($dailyLimit - $dailyUsed, 0);

    $dailyPercentage = $dailyLimit > 0
    ? round(($dailyRemaining / $dailyLimit) * 100)
    : 0;


    $color = 'bg-green-500';

    if ($percentage < 70) {
        $color = 'bg-yellow-500';
    }

    if ($percentage < 30) {
        $color = 'bg-red-500';
    }
@endphp

    <flux:main>
        <flux:heading size="xl" level="1">Pricing</flux:heading>

        

        @if (session('success'))
            <div class="mt-2 p-3 bg-green-100 text-green-700 rounded-lg border border-green-200">
                {{ session('success') }}
            </div>
        @endif

        

        <flux:separator variant="subtle" />

        
        <div class="lg:grid grid-cols-2 gap-6 mt-4">

            @foreach($plans as $plan)

                <div class="rounded-[2vw] overflow-hidden leading-9 shadow-lg border p-6">

                    <h2 class="text-2xl font-bold">
                        {{ $plan->name }}
                    </h2>
                    
                    @if(auth()->user()->hasRole('Admin'))
                        <flux:button
                            :href="route('plans.edit', $plan)"
                            variant="subtle"
                        >
                            Edit Plan
                        </flux:button>
                    @endif

                    <p class="text-xl mt-2">
                        ₹{{ number_format($plan->price) }} / Month
                    </p>

                    <p class="mt-3">
                        {{ number_format($plan->ai_credits) }} AI Credits
                    </p>

                    <li>✔ {{ number_format($plan->daily_ai_credit_limit) }} AI Credits / Day</li>

                    @if($plan->features)
                        <ul class="mt-4 space-y-2">
                            @foreach($plan->features as $feature)
                                <li> {{ $feature }}</li>
                            @endforeach
                        </ul>
                    @endif


                    <div class="mt-6">

                        @if($plan->price == 0)

                            @if(auth()->user()->subscribed('default'))

                                <flux:button disabled>
                                    Active Pro Subscription
                                </flux:button>

                            @elseif(auth()->user()->plan && auth()->user()->plan->price > 0)

                                <flux:button disabled>
                                    Active Pro Plan
                                </flux:button>

                            @elseif(auth()->user()->plan_id === $plan->id)

                                <flux:button color="green">
                                    Current Plan
                                </flux:button>

                            @else

                                <form method="POST" action="{{ route('plans.free', $plan) }}">
                                    @csrf

                                    <flux:button
                                        type="submit"
                                        color="green">
                                        Try for Free
                                    </flux:button>

                                </form>

                            @endif

                        @else

                        @if(
                            auth()->user()->subscribed('default') &&
                            optional($currentPlan)->id === $plan->id
                        )

                            <flux:button color="green">
                                Current Plan
                            </flux:button>

                        @elseif(auth()->user()->plan_id === $plan->id)

                            <flux:button color="green">
                                Current Plan
                            </flux:button>

                        @else

                            <form action="{{ route('checkout', $plan) }}" method="POST">
                                @csrf

                                <flux:button type="submit">
                                    Upgrade to {{ $plan->name }}
                                </flux:button>

                            </form>

                        @endif

                    @endif

                    </div>
                    
                </div>
            @endforeach
            
        </div>

            <div class="mt-8">
        
                @if(auth()->user()->plan_id)

                    @php
                        $subscription = auth()->user()->subscription('default');
                    @endphp

                    <h3 class="text-lg font-semibold text-green-700">
                        Current Membership
                    </h3>
                    <flux:table>

                        <flux:table.columns>
                            <flux:table.column>ID</flux:table.column>
                            <flux:table.column>Current Plan</flux:table.column>
                            <flux:table.column>Status</flux:table.column>
                            <flux:table.column>Current Period</flux:table.column>
                            <flux:table.column>Next Billing</flux:table.column>
                            <flux:table.column>Credit Reset</flux:table.column>
                            <flux:table.column>Credits Remaining</flux:table.column>
                            <flux:table.column>Daily Limit</flux:table.column>
                            <flux:table.column>Auto Renew</flux:table.column>
                            <flux:table.column>Action</flux:table.column>
                        </flux:table.columns>

                        <flux:table.rows>

                            <flux:table.row>

                                <flux:table.cell>
                                    {{ $subscription?->id ?? 'Free' }}
                                </flux:table.cell>

                                <flux:table.cell>
                                   {{ auth()->user()->plan?->name ?? $currentPlan?->name ?? 'Basic' }}
                                </flux:table.cell>
                                <!-- Current Plan -->
                              

                                <flux:table.cell>

                                    @if(auth()->user()->plan && auth()->user()->plan->price > 0)

                                        @if($subscription && $subscription->onGracePeriod())

                                            <flux:text class="text-yellow-600">
                                                Cancelling
                                            </flux:text>

                                        @elseif($subscription && $subscription->valid())

                                            <flux:text class="text-green-600">
                                                Active
                                            </flux:text>

                                        @else

                                            <flux:text class="text-green-600">
                                                Active
                                            </flux:text>

                                        @endif

                                    @else

                                        <flux:text class="text-blue-600">
                                            Free Plan
                                        </flux:text>

                                    @endif

                                </flux:table.cell>
                                <!-- Status -->
                                  
                                <flux:table.cell>
                                    {{ $subscription?->currentPeriodStart()->format('M d, Y') }} 
                                </flux:table.cell>
                                <!-- Current Period -->

                                <flux:table.cell>
                                    @if($subscription)
                                    {{ $nextBilling?->format('d M Y') ?? '-' }}
                                    @else
                                        -
                                    @endif
                                </flux:table.cell>
                                <!-- Next Billing -->

                                <flux:table.cell>
                                    @if(!$subscription)
                                        {{ auth()->user()->credits_reset_at?->format('d M Y') ?? '-' }}
                                    @else
                                        -
                                    @endif
                                </flux:table.cell>
                                <!-- Credits Reset Date -->

                                <flux:table.cell>

                                    <div class="font-semibold">
                                        {{ number_format($remaining) }} / {{ number_format($total) }}
                                    </div>

                                    <div class="w-36 h-2 bg-gray-200 rounded-full mt-2">
                                        <div
                                            class="{{ $color }} h-2 rounded-full transition-all duration-500"
                                            style="width: {{ $percentage }}%">
                                        </div>
                                    </div>

                                    <div class="text-xs text-gray-500 mt-1">
                                        {{ $percentage }}% Remaining
                                    </div>

                                </flux:table.cell>
                                <!-- Credits Remaining -->

                                <flux:table.cell>

                                    <div class="font-semibold">
                                        {{ number_format($dailyRemaining) }} /
                                        {{ number_format($dailyLimit) }}
                                    </div>

                                    <div class="w-36 h-2 bg-gray-200 rounded-full mt-2">
                                        <div
                                            class="bg-blue-500 h-2 rounded-full"
                                            style="width: {{ $dailyPercentage }}%">
                                        </div>
                                    </div>

                                    <div class="text-xs text-gray-500 mt-1">
                                        {{ $dailyUsed }} Used Today
                                    </div>

                                </flux:table.cell>
                                <!-- Daily Limit -->

                                <flux:table.cell>
                                    @if($subscription)
                                        {{ $subscription->onGracePeriod() ? 'No' : 'Yes' }}
                                    @else
                                        -
                                    @endif
                                </flux:table.cell>
                                <!-- Auto Renew -->

                                <flux:table.cell>

                                    @if($subscription)

                                        <form action="{{ route('subscription.cancel') }}" method="POST">
                                            @csrf

                                            <flux:button
                                                type="submit"
                                                variant="danger">
                                                Cancel Subscription
                                            </flux:button>

                                        </form>

                                        @else

                                        <flux:text class="text-gray-500">
                                            No action available
                                        </flux:text>

                                    @endif

                                </flux:table.cell>
                                <!-- Action -->

                            </flux:table.row>

                        </flux:table.rows>

                    </flux:table>

                @endif

            </div>

    </flux:main>

</x-app-layout>