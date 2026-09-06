<x-app-layout>

    @include('sidebar.side')

    <flux:main>

        <flux:heading size="xl" level="1">
            Invoice List
        </flux:heading>

        <flux:separator variant="subtle" class="mb-6" />

        <flux:table>

            <flux:table.columns>
                <flux:table.column>Customer</flux:table.column>
                <flux:table.column>Name</flux:table.column>
                <flux:table.column>Email</flux:table.column>
                <flux:table.column>Total Invoices</flux:table.column>
                <flux:table.column>Action</flux:table.column>
               
            </flux:table.columns>

            <flux:table.rows>

                @foreach($users as $user)

                    <flux:table.row>

                        <flux:table.cell>{{ $user->id }}</flux:table.cell>

                        <flux:table.cell>{{ $user->name }}</flux:table.cell>

                        <flux:table.cell>{{ $user->email }}</flux:table.cell>

                        <flux:table.cell>
                            {{ count($user->invoices()) }}
                        </flux:table.cell>

                        <flux:table.cell>
                            <div class="py-4">
                                <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700">
                                    <flux:link href="{{route('invoice.show', $user->id)}}">
                                        View
                                    </flux:link>
                                </span>
                                
                            </div>
                        </flux:table.cell>

                    </flux:table.row>

                @endforeach

            </flux:table.rows>

        </flux:table>

        <div class="mt-6">
            {{ $users->links() }}
        </div>

    </flux:main>

</x-app-layout>