<x-app-layout>
    
    @include('sidebar.side')

    <flux:main>
        <flux:heading size="xl" level="1">{{ Auth::user()->name }}</flux:heading>


        <flux:separator variant="subtle" />


        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

            <div class="rounded-2xl border bg-white dark:bg-zinc-900 p-6 shadow">

                <h2 class="text-lg font-semibold text-gray-500 dark:text-gray-400">
                    Total Users
                </h2>
                
                <p class="text-4xl font-bold mt-3">
                    {{ $totalUsers }}
                </p>
                
                <flux:link href="{{ route('view-all-users') }}" class="mt-4">
                    View All Users
                </flux:link>

            </div>
            <!-- All Users -->

            <div class="rounded-2xl border bg-white dark:bg-zinc-900 p-6 shadow">

                <h2 class="text-lg font-semibold text-gray-500 dark:text-gray-400">
                    Total Subscriptions
                </h2>

                <p class="text-4xl font-bold mt-3">
                    {{ $totalSubscriptions }}
                </p>

                <flux:link href="{{ route('subscriber-list') }}" class="mt-4">
                    View All Subscribers
                </flux:link>

            </div>
            <!-- Subsciber list -->

            <div class="rounded-2xl border bg-white dark:bg-zinc-900 p-6 shadow">

                <h2 class="text-lg font-semibold text-gray-500 dark:text-gray-400">
                    Cancelling Subscriptions
                </h2>

                <p class="text-4xl font-bold mt-3">
                    {{ $totalCancellingSubscriptions }}
                </p>

                <flux:link href="{{ route('cancelling-subscriber-list') }}" class="mt-4">
                    View All Cancelling Subscribers
                </flux:link>

            </div>
            <!-- Cancelled Subscriptions -->

            <div class="rounded-2xl border bg-white dark:bg-zinc-900 p-6 shadow">

                <h2 class="text-lg font-semibold text-gray-500 dark:text-gray-400">
                    Active Subscriptions
                </h2>

                <p class="text-4xl font-bold mt-3">
                   {{ $totalActiveSubscriptions }}
                </p>

                <flux:link href="{{ route('cancelling-subscriber-list') }}" class="mt-4">
                    View All active Subscribers
                </flux:link>

            </div>
            <!-- Active Subscriptions -->

            <div class="rounded-2xl border bg-white dark:bg-zinc-900 p-6 shadow">

                <h2 class="text-lg font-semibold text-gray-500 dark:text-gray-400">
                    Renew Subscriptions
                </h2>

                <p class="text-4xl font-bold mt-3">
                    {{ $totalRenewSubscriptions }}
                </p>

                <flux:link href="{{ route('cancelling-subscriber-list') }}" class="mt-4">
                    View All renew Subscribers
                </flux:link>

            </div>
            <!-- Renew Subscriptions -->

            <div class="rounded-2xl border bg-white dark:bg-zinc-900 p-6 shadow">

                <h2 class="text-lg font-semibold text-gray-500 dark:text-gray-400">
                    View Customer Invoice
                </h2>

                <p class="text-4xl font-bold mt-3">
                    
                </p>

                @hasanyrole('Admin|Accountant')
                    <flux:link href="{{ route('invoice-list') }}" class="mt-4">
                        View All Invoices
                    </flux:link>
                @endhasanyrole

            </div>


        </div>

    </flux:main>

  
</x-app-layout>
