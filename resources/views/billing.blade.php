<x-app-layout>

    @include('sidebar.side')

    <flux:main>

        <flux:heading size="xl" level="1">Billing</flux:heading>

        <flux:separator variant="subtle" class="mb-6" />

        
            <div class="mb-6 rounded-lg border border-green-300 bg-green-50 p-4">

                <h3 class="text-lg font-semibold text-green-700">
                    Your billing information
                </h3>

            </div>
        
            <form method="GET" class="mb-4">
                <select
                    name="period"
                    onchange="this.form.submit()"
                    class="rounded-lg border border-zinc-300 bg-white px-6 py-2 text-sm shadow-sm focus:border-zinc-500 focus:outline-none dark:border-zinc-700 dark:bg-zinc-900"
                >
                    <option value="3" {{ request('period', '3') == '3' ? 'selected' : '' }}>
                        Last 3 Months
                    </option>

                    <option value="6" {{ request('period') == '6' ? 'selected' : '' }}>
                        Last 6 Months
                    </option>

                    <option value="12" {{ request('period') == '12' ? 'selected' : '' }}>
                        Last 12 Months
                    </option>

                    <option value="all" {{ request('period') == 'all' ? 'selected' : '' }}>
                        All Invoices
                    </option>
                </select>
            </form>

            @if($subscription)

            <flux:table>

                <flux:table.columns>
                    <flux:table.column>Date</flux:table.column>
                    <flux:table.column>Amount</flux:table.column>
                    <flux:table.column>Status</flux:table.column>
                    <flux:table.column>Invoice</flux:table.column>
                    <flux:table.column>Action</flux:table.column>
                </flux:table.columns>

                <flux:table.rows>

                    @foreach($invoices as $invoice)

                        <flux:table.row>

                            <flux:table.cell>
                                {{ $invoice->date()->format('d M Y') }}
                            </flux:table.cell>

                            <flux:table.cell>
                                {{ $invoice->total() }}
                            </flux:table.cell>

                            <flux:table.cell>
                                Paid
                            </flux:table.cell>

                            <flux:table.cell>
                                {{ $invoice->id }}
                            </flux:table.cell>

                            <flux:table.cell>

                                <a href="{{ route('billing.download', $invoice->id) }}">
                                    <flux:button variant="primary">
                                        Download PDF
                                    </flux:button>
                                </a>

                            </flux:table.cell>

                        </flux:table.row>

                    @endforeach

                </flux:table.rows>

            </flux:table>

            @else

                <div class="rounded-lg border border-yellow-300 bg-yellow-50 p-4">
                    No billing information available.
                </div>

            @endif

   
    </flux:main>

</x-app-layout>