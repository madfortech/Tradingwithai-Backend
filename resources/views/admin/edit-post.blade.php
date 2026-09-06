<x-app-layout>
    
    @include('sidebar.side')

    <flux:main>
        <flux:heading size="xl" level="1">Add New Post</flux:heading>


        <flux:separator variant="subtle" />


        <livewire:post.edit :post="$post" />
    </flux:main>

  
</x-app-layout>
