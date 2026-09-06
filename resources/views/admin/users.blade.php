<x-app-layout>

    @include('sidebar.side')

    <flux:main>

        <flux:heading size="xl" level="1">
            All Users
        </flux:heading>

        <flux:separator variant="subtle" class="mb-6" />

        <flux:table>

            <flux:table.columns>
                <flux:table.column>ID</flux:table.column>
                <flux:table.column>Name</flux:table.column>
                <flux:table.column>Email</flux:table.column>
                <flux:table.column>Created At</flux:table.column>
                <flux:table.column>Updated At</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>

                @foreach($users as $user)

                    <flux:table.row>

                        <flux:table.cell>{{ $user->id }}</flux:table.cell>

                        <flux:table.cell>{{ $user->name }}</flux:table.cell>

                        <flux:table.cell>{{ $user->email }}</flux:table.cell>

                        <flux:table.cell>{{ $user->created_at->format('d M Y H:i:s') }}</flux:table.cell>

                        <flux:table.cell>{{ $user->updated_at->format('d M Y H:i:s') }}</flux:table.cell>

                    </flux:table.row>

                @endforeach

            </flux:table.rows>

        </flux:table>

        <div class="mt-6">
            {{ $users->links() }}
        </div>

    </flux:main>

</x-app-layout>