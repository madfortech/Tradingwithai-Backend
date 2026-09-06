<x-app-layout>
 
    @include('sidebar.side')

    <flux:header class="lg:hidden">
        <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

        <flux:spacer />

        <flux:dropdown position="top" alignt="start">
            <flux:profile name="{{ Auth::user()->name }}"  />

            <flux:menu>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <flux:menu.item icon="arrow-right-start-on-rectangle" :href="route('logout')"
                        onclick="event.preventDefault();
                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </flux:menu.item>
                </form>
            </flux:menu>
        </flux:dropdown>
    </flux:header>

    <flux:main>
        <flux:heading size="xl" level="1">
            {{ Auth::user()->name }}
        </flux:heading>

        
        <flux:separator variant="subtle" />
    </flux:main>
 
</x-app-layout>
