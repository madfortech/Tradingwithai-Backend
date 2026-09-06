<?php

use Livewire\Component;
use App\Models\Page;
use Livewire\Attributes\Rule;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

new class extends Component
{
    public ?Page $page = null;

    #[Rule('required|min:3|max:255')]
    public string $title = '';

    #[Rule('required')]
    public string $slug = '';

    #[Rule('required')]
    public string $content = '';

    public bool $is_published = true;

    public function mount(string $slug): void
    {
        $this->slug = $slug;

        $this->page = Page::firstOrCreate(
            ['slug' => $slug],
            [
                'title' => str($slug)->replace('-', ' ')->title(),
                'content' => '',
                'is_published' => true,
            ]
        );

        $this->title = $this->page->title;
        $this->slug = $this->page->slug;
        $this->content = $this->page->content;
        $this->is_published = $this->page->is_published;
    }

     
    public function submitForm()
    {
        
        $this->validate();

        $this->page->update([
            'title' => $this->title,
            'slug' => $this->slug,
            'content' => $this->content,
            'is_published' => $this->is_published,
        ]);

        
        session()->flash('success', "{$this->title} saved successfully.");
    }

};
?>


    <div class="p-4">

        @if(session()->has('success'))
        <flux:text class="mt-2 text-green-600">{{ session('success') }}</flux:text>
        @endif

        <form wire:submit="submitForm" class="border-b-2 pb-10">
            <flux:field class="mb-4">
                <flux:label>Title</flux:label>

                <flux:input wire:model="title" readonly />

                @error('title')
                    <flux:error name="title" />
                @enderror
            </flux:field>
           
            <!-- Title Field -->

            <flux:field class="mb-4">
                <flux:label>Slug</flux:label>

                <flux:input wire:model="slug" readonly />

                @error('slug')
                    <flux:error name="slug" />
                @enderror
            </flux:field>
            <!-- Slug Field -->
 
            
            <div wire:ignore class="mb-4 py-2 px-3">
                <div id="editor"></div>
            </div>

            <input type="hidden" wire:model="content" id="content">

            @error('content')
                <div class="mt-1 text-sm text-red-500">
                    {{ $message }}
                </div>
            @enderror

            <!-- Content Field -->

            <flux:button type="submit" color="blue">
                Save
            </flux:button>

            
        </form>
    </div>


@script
<script>
    const quill = new Quill('#editor', {
        theme: 'snow'
    });

    quill.on('text-change', () => {
        document.getElementById('content').value = quill.root.innerHTML;

        document.getElementById('content').dispatchEvent(
            new Event('input', { bubbles: true })
        );
    });
</script>
@endscript