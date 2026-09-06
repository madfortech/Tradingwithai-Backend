<x-app-layout>
    
   
    <flux:main>
        <flux:heading size="xl" level="1">Privacy Policy</flux:heading>

        <flux:separator variant="subtle" />
        
        <div class="prose max-w-none py-6 mt-6">
            {!! $page->content !!}

            <flux:separator />
            <p class="text-sm text-gray-500 mt-4">Last updated: {!! $page->created_at->format('F d, Y') !!}</p>

           
                @role('Admin')
                    
                    <flux:button
                        class="mt-4"
                        href="{{ route('legal.editor', ['slug' => 'privacy-policy']) }}">
                        Edit Privacy Policy
                    </flux:button>
                    
                @endrole
           
        </div>
    </flux:main>

  
</x-app-layout>
