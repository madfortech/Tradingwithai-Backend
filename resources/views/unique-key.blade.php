<x-app-layout>

    @include('sidebar.side')

    <flux:main>

        <flux:heading size="xl" level="1">Unique Key</flux:heading>

        <flux:separator variant="subtle" class="mb-6" />

        @if($plainKey)
            <div class="mb-6 rounded-lg border border-green-300 bg-green-50 p-4">

                <h3 class="text-lg font-semibold text-green-700">
                    🎉 Your unique key
                </h3>

                <div class="mt-3 rounded bg-white p-3 font-mono break-all">
                    {{ $plainKey }}
                </div>

                <p class="mt-3 text-sm text-red-600">
                    Copy this key now. It will never be shown again.
                </p>

            </div>
        @endif

        @if($uniqueKey)

            <flux:table>

                <flux:table.columns>
                    <flux:table.column>ID</flux:table.column>
                    <flux:table.column>Name</flux:table.column>
                    <flux:table.column>Status</flux:table.column>
                    <flux:table.column>Last Used</flux:table.column>
                    <flux:table.column>Created</flux:table.column>
                    <flux:table.column>Action</flux:table.column>
                </flux:table.columns>

                <flux:table.rows>

                    <flux:table.row>

                        <flux:table.cell>{{ $uniqueKey->id }}</flux:table.cell>

                        <flux:table.cell>{{ $uniqueKey->name }}</flux:table.cell>

                        <flux:table.cell>
                            {{ $uniqueKey->revoked_at ? 'Revoked' : 'Active' }}
                        </flux:table.cell>

                        <flux:table.cell>
                            {{ $uniqueKey->last_used_at ?? 'Never' }}
                        </flux:table.cell>

                        <flux:table.cell>
                            {{ $uniqueKey->created_at->format('d M Y') }}
                        </flux:table.cell>

                        <flux:table.cell>

                            <form method="POST"
                                action="{{ route('unique-key.regenerate') }}"
                                onsubmit="return confirm('Regenerate your Unique Key? Your current key will stop working immediately.')">

                                @csrf

                                <flux:button
                                    type="submit"
                                    variant="danger">

                                    Regenerate

                                </flux:button>
                               

                            </form>

                        </flux:table.cell>

                    </flux:table.row>

                </flux:table.rows>

            </flux:table>

        @else

            <div class="rounded-lg border border-yellow-300 bg-yellow-50 p-4">

                No Unique Key has been generated yet.

            </div>

        @endif

    </flux:main>

</x-app-layout>