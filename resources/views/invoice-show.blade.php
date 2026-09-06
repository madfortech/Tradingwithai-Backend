<x-app-layout>

    @include('sidebar.side')

    <flux:main>

        <flux:heading size="xl" level="1">
            {{ $user->name }}'s Invoices
        </flux:heading>

        <flux:separator variant="subtle" class="mb-6" />

        <flux:table>

            <flux:table.columns>
                <flux:table.column>Invoice</flux:table.column>
                <flux:table.column>Amount</flux:table.column>
                <flux:table.column>Date</flux:table.column>
                <flux:table.column>Status</flux:table.column>
                <flux:table.column>Action</flux:table.column>
               
            </flux:table.columns>

            <flux:table.rows>

                @foreach($invoices as $invoice)

                    <flux:table.row>

                        <flux:table.cell>
                            {{ $invoice->number ?? $invoice->id }}
                        </flux:table.cell>

                        <flux:table.cell>{{ $invoice->total() }}</flux:table.cell>

                        <flux:table.cell>{{ $invoice->date()->format('d M Y') }}</flux:table.cell>

                       <flux:table.cell>
                            <flux:badge color="{{ $invoice->status === 'paid' ? 'green' : 'yellow' }}">
                                {{ ucfirst($invoice->status) }}
                            </flux:badge>
                        </flux:table.cell>

                        <flux:table.cell>
                            <div class="py-4">
                                
                                <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700">
                                    <flux:link href="{{ route('invoice.download', [$user, $invoice->id]) }}">
                                        Download
                                    </flux:link>
                                </span>
                                
                            </div>
                        </flux:table.cell>

                    </flux:table.row>

                @endforeach

            </flux:table.rows>

        </flux:table>

        

    </flux:main>

</x-app-layout>