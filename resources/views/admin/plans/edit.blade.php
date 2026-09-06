<x-app-layout>
    
    @include('sidebar.side')

    <flux:main>
        <flux:heading size="xl" level="1">Edit Plan</flux:heading>


        <flux:separator variant="subtle" />

        <form  action="{{ route('plans.update', $plan) }}" method="POST"  class="border-b-2 py-4">
            @csrf
            @method('PUT')

            <div class="mb-2">
                <flux:input label="Name" name="name" value="{{ old('name', $plan->name) }}" />
            </div>
            <!-- Price -->

            <div class="mb-2">
                <flux:input readonly label="Slug" name="slug" value="{{ old('slug', $plan->slug) }}" />
            </div>
            <!-- Credits -->

            <div class="mb-2">
                <flux:input label="Price" name="price" value="{{ old('price', $plan->price) }}" />
            </div>
            <!-- Price -->

            <div class="mb-2">
                <flux:input
                    label="AI Credits"
                    name="ai_credits"
                    value="{{ old('ai_credits', $plan->ai_credits) }}" />
            </div>
            <!-- AiCredits -->

            <div class="mb-2">
                <flux:checkbox label="Active" name="active" value="{{ old('active', $plan->active) }}" />
            </div>
            <!-- Active -->

            <div class="flex items-center gap-3">
                <input
                    type="checkbox"
                    name="is_active"
                    value="1"
                    {{ $plan->is_active ? 'checked' : '' }}
                >

                <label>
                    Plan Active
                </label>
            </div>
            
            <div class="mb-2">
                <flux:textarea 
                    label="Features (one per line)" 
                    name="features" 
                    rows="6"
                >{{ old('features', is_array($plan->features) ? implode("\n", $plan->features) : '') }}</flux:textarea>
            </div>
            <!-- features Field -->

            <div class="mb-2">
                <flux:button type="submit">
                    Update
                </flux:button>
            </div>

            
        </form>
         
    </flux:main>

  
</x-app-layout>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const quill = new Quill('#editor', {
        theme: 'snow'
    });

    const hidden = document.getElementById('features');

    quill.root.innerHTML = hidden.value ?? '';

    document.querySelector('form').addEventListener('submit', function () {

        hidden.value = quill.root.innerHTML;

        console.log(hidden.value);

    });

});
</script>