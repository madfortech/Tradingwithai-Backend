<?php

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Rule;
use App\Models\Post;

new class extends Component
{
    use WithFileUploads;

    public Post $post;

    public string $title = '';
    public string $slug = '';
    public string $content = '';

    #[Rule('nullable|file|mimetypes:video/mp4,video/quicktime|max:1048576')]
    public $file = null;

    public function mount(Post $post): void
    {
        $this->post = $post;

        $this->title = $post->title;
        $this->slug = $post->slug;
        $this->content = $post->content;
    }

    public function updatedTitle($value): void
    {
        $this->slug = \Cviebrock\EloquentSluggable\Services\SlugService::createSlug(
            Post::class,
            'slug',
            $value,
            ['unique' => false]
        );
    }

    public function update(): void
    {
        $this->validate();

        $this->post->update([
            'title' => $this->title,
            'slug' => $this->slug,
            'content' => $this->content,
        ]);

        // New video selected?
        if ($this->file) {

            // Remove old video
            $this->post->clearMediaCollection('media');

            // Add new video
            $this->post
                ->addMedia($this->file->getRealPath())
                ->usingFileName($this->file->getClientOriginalName())
                ->toMediaCollection('media');
        }

        $this->reset('file');

        session()->flash(
            'success',
            'Post updated successfully.'
        );
    }
};
?>

  <div class="p-4">

        @if(session()->has('success'))
        <flux:text class="mt-2 text-green-600">{{ session('success') }}</flux:text>
        @endif

        <form wire:submit="update" class="border-b-2 pb-10">
            <flux:field class="mb-4">
                <flux:label>Title</flux:label>

                <flux:input wire:model.live.blur="title" type="text" />
 
            </flux:field>
           
            <!-- Title Field -->

            <flux:field class="mb-4">
                <flux:label>Slug</flux:label>

                <flux:input value="{{ $this->slug }}" readonly type="text" />

                @error('slug')
                    <flux:error name="slug" />
                @enderror
            </flux:field>
            <!-- Slug -->
  
            <!-- Slug Field -->
 
            <!-- <flux:field class="mb-4">
                <flux:label>Content</flux:label>
                <flux:textarea wire:model.live.blur="content" />
               
            </flux:field> -->


            <!-- Video -->
            <div class="mb-4 px-3">

                <flux:label>
                    Current Video
                </flux:label>

                @if ($post->getFirstMediaUrl('media'))
                    <div class="mt-2 overflow-hidden rounded-lg bg-black">
                        <video
                            class="aspect-video w-full object-contain"
                            controls
                            preload="metadata"
                        >
                            <source
                                src="{{ $post->getFirstMediaUrl('media') }}"
                                type="{{ $post->getFirstMedia('media')?->mime_type }}"
                            >
                        </video>
                    </div>
                @endif

            </div>
            <!-- Video -->

            <div wire:ignore class="mb-4 py-2 px-3">
                <div id="editor"></div>
            </div>

            <input type="hidden" value="{{ $this->content }}" name="content" id="content">

            @error('content')
                <div class="mt-1 text-sm text-red-500">
                    {{ $message }}
                </div>
            @enderror

            <!-- Content Field -->

            <flux:button type="submit" color="green">
                Update
            </flux:button>

            
        </form>
    </div>

@script
<script>
    const quill = new Quill('#editor', {
        theme: 'snow'
    });

    quill.root.innerHTML = @js($this->content);

    quill.on('text-change', () => {
        const content = document.getElementById('content');

        content.value = quill.root.innerHTML;

        content.dispatchEvent(
            new Event('input', {
                bubbles: true
            })
        );
    });
</script>
@endscript