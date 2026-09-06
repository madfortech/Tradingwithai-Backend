<?php

use Livewire\Component;
use App\Models\Post;
use Livewire\WithFileUploads;
use Livewire\Attributes\Rule;
use Cviebrock\EloquentSluggable\Services\SlugService;

new class extends Component
{
    use WithFileUploads;

    #[Rule('required|max:100')]
    public string $title = '';

    public string $slug = '';

    #[Rule('required|file|mimetypes:video/mp4,video/quicktime|max:102400')]
    public $file = null;

    #[Rule('required')]
    public string $content = '';

    public function updatedTitle($value): void
    {
        $this->slug = SlugService::createSlug(
            Post::class,
            'slug',
            $value
        );
    }

    public function storePost(): void
    {
        $this->validate();

        $post = Post::create([
            'title' => $this->title,
            'slug' => $this->slug,
            'content' => $this->content,
        ]);

        $post->addMedia($this->file->getRealPath())
            ->usingFileName($this->file->getClientOriginalName()) // extension preserve karega
            ->toMediaCollection('media');

        $this->reset();

        session()->flash(
            'success',
            'Post created successfully.'
        );
    }
};
?>


<div>
    <div class="p-4">

        @if(session()->has('success'))
            <flux:text class="mt-2 text-green-600">
                {{ session('success') }}
            </flux:text>
        @endif

        <form wire:submit="storePost" class="border-b-2 pb-10">

            <!-- Title -->
            <div class="py-2 px-3">
                <label for="title">Title</label>

               <input
                    id="title"
                    type="text"
                    wire:model.live.debounce.500ms="title"
                    placeholder="Enter post title"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                />

                @error('title')
                    <flux:text class="mt-1 text-sm text-red-500">
                        {{ $message }}
                    </flux:text>
                @enderror
            </div>
            <!-- /Title -->

            <!-- Slug -->
            <div class="py-2 px-3">
                <label for="slug">Slug</label>

                <input
                    id="slug"
                    type="text"
                    value="{{ $slug }}"
                    readonly
                    class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100"
                />
            </div>
            <!-- /Slug -->

            <!-- TODO: Add video upload field here -->
            <div class="py-2 px-3">
                <label class="block mb-2" for="video">
                    Video
                </label>

                <div wire:ignore>
                    <input
                        id="video"
                        type="file"
                        accept="video/mp4,video/quicktime"
                    >
                </div>

                @error('file')
                    <div class="mt-1 text-sm text-red-500">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <!-- Video upload field will go here -->

            <!-- Content -->
            <div class="py-2 px-3">
                <div wire:ignore class="mb-4 py-2 px-3">
                    <div id="editor"></div>
                </div>

                <input
                    type="hidden"
                    wire:model="content"
                    id="content">

                @error('content')
                    <div class="mt-1 text-sm text-red-500">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <!-- /Content -->

            <!-- Submit -->
            <flux:button
                variant="primary"
                type="submit"
                color="blue">
                Save
            </flux:button>

        </form>
    </div>
</div>

@script
<script>
    const input = document.querySelector('#video');

    if (input && !input._filePond) {

        FilePond.registerPlugin(
            FilePondPluginFileValidateType
        );

        const pond = FilePond.create(input, {
            allowMultiple: false,

            allowFileTypeValidation: true,

            acceptedFileTypes: [
                'video/mp4',
                'video/quicktime'
            ],

            server: {
                process: (
                    fieldName,
                    file,
                    metadata,
                    load,
                    error,
                    progress,
                    abort
                ) => {
                    $wire.upload(
                        'file',
                        file,
                        load,
                        error,
                        progress
                    );
                },

                revert: (
                    filename,
                    load
                ) => {
                    $wire.removeUpload(
                        'file',
                        filename,
                        load
                    );
                }
            }
        });

        input._filePond = pond;
    }

    const quill = new Quill('#editor', {
        theme: 'snow'
    });

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