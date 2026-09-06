    <flux:sidebar sticky collapsible="mobile" class="bg-zinc-50 dark:bg-zinc-900 border-r border-zinc-200 dark:border-zinc-700">
        <flux:sidebar.header>
            
            <flux:sidebar.collapse class="lg:hidden" />
        </flux:sidebar.header>

        

        <flux:sidebar.nav>
            <flux:sidebar.item icon="home" href="{{ route('dashboard') }}" current>Home</flux:sidebar.item>
            <flux:sidebar.item icon="plus" href="{{ route('pricing') }}">Plan</flux:sidebar.item>
            
            <flux:sidebar.group expandable heading="Account" class="grid">
                <flux:sidebar.item icon="key" href="{{ route('unique-key') }}">Unique Key</flux:sidebar.item>
                
            </flux:sidebar.group>

            <!-- Billing History -->
            <flux:sidebar.group expandable heading="Billing History" class="grid">
               
                <flux:sidebar.item href="{{ route('billing') }}" icon="document-text">Invoices</flux:sidebar.item>

                @role('Admin|Accountant')
                <flux:sidebar.item href="{{ route('invoice-list') }}" icon="document-text">
                        View All Invoices
                    </flux:sidebar.item>
                @endrole
            </flux:sidebar.group>
            <!-- Billing History -->

            <!-- Legal -->
            <flux:sidebar.group expandable heading="Legal" class="grid">
               
                <flux:sidebar.item
                    href="{{ route('pages.editor', 'privacy-policy') }}"
                    icon="shield-check"
                >
                    Privacy Policy
                </flux:sidebar.item>

                <flux:sidebar.item
                    href="{{ route('pages.editor', ['slug' => 'terms-and-conditions']) }}"
                    icon="clipboard-document-list"
                >
                    Terms & Conditions
                </flux:sidebar.item>

                <flux:sidebar.item
                    href="{{ route('pages.editor', ['slug' => 'refund-policy']) }}"
                    icon="arrow-uturn-left"
                >
                    Refund Policy
                </flux:sidebar.item>

               
            </flux:sidebar.group>
            <!-- Legal -->

            <!-- Add Posts -->
            @role('Admin')
            <flux:sidebar.group expandable heading="Posts" class="grid">
                <flux:sidebar.item href="{{ route('add-new-post') }}" icon="clipboard-document-list">
                    Add New Post
                </flux:sidebar.item>
            </flux:sidebar.group>
            @endrole
            <!-- Add Posts -->

        </flux:sidebar.nav>

        <flux:sidebar.spacer />

        <flux:sidebar.nav>
            <flux:sidebar.item icon="cog-6-tooth" href="{{ route('profile.edit') }}">Settings</flux:sidebar.item>
        </flux:sidebar.nav>

        <flux:dropdown position="top" align="start" class="max-lg:hidden">
            <flux:sidebar.profile name="{{ Auth::user()->name }}" />

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
    </flux:sidebar>