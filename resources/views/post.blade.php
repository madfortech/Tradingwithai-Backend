<x-app-layout>
    
   

    <flux:main>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <flux:heading size="xl" level="1">Posts</flux:heading>
           
            <flux:separator variant="subtle" />

            <div class="lg:grid grid-flow-row-dense grid-cols-1 grid-rows-3">
                <!-- Posts -->
                <div class="col-span-2">
                    <div class="mt-4">
                       
                        <div class="max-w-full mx-auto rounded overflow-hidden shadow-lg px-4">
                               
                            <video
                                class="aspect-video w-full"
                                controls
                                preload="metadata">
                                <source
                                    src="{{ $post->getFirstMediaUrl('media') }}"
                                    type="video/mp4"
                                    alt="{{ $post->title }}">
                            </video>
                            <div class="px-6 py-4">
                                <div class="font-bold text-xl mb-2">{{ $post->title }}</div>
                                <p class="text-gray-600">
                                    {!! $post->content !!}
                                </p>
                                <div class="py-4">
                                    <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700">{{ $post->created_at->format('M d, Y') }}</span>
                                    @role('Admin')
                                        <flux:link  variant="primary" color="green" href="{{ route('edit-post', ['post' => $post->id]) }}">
                                            Edit
                                        </flux:link>
                                    @endrole
                                </div>
                            </div>
                            
                        </div>
                       
                    </div>
                </div>
                <!-- Posts -->

                <!-- Sidebar -->
                <div class="col-span-1">
                    a
                </div>
            </div>
        </div>
    </flux:main>

  
</x-app-layout>
