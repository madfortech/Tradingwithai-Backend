<x-app-layout>
    
    @include('sidebar.side')

    <flux:main>
       

        <flux:heading size="xl" level="1">
            {{ str($slug)->replace('-', ' ')->title() }}
        </flux:heading>
        <flux:separator variant="subtle" />

        <livewire:legal-page-editor :slug="$slug" />
         
    </flux:main>

  
</x-app-layout>
