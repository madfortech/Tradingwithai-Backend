<x-app-layout>
    
    @include('sidebar.side')

    <flux:main>
        <flux:heading size="xl" level="1">Add New Post</flux:heading>


        <flux:separator variant="subtle" />

        <livewire:post.create />
         
    </flux:main>

  
</x-app-layout>
