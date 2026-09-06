<?php

use Livewire\Component;

new class extends Component
{
    public function render()
    {
        return $this->view();
    }
};
?>

<x-mobile-layout>
    
    <div class="min-h-screen p-5">
        <h1 class="text-2xl font-bold">
            TradeWithAI
        </h1>

        <p class="mt-2 text-slate-400">
            Mobile Home
        </p>

        
    </div>
    
</x-mobile-layout>
 <native:bottom-nav label-visibility="labeled">

    <native:bottom-nav-item
        id="home"
        icon="home"
        label="Home"
        url="/home"
        :active="true"
    />

    <native:bottom-nav-item
        id="friends"
        icon="person.3.fill"
        label="Friends"
        url="/friends"
    />

    <native:bottom-nav-item
        id="profile"
        icon="person"
        label="Profile"
        url="/profile"
    />

</native:bottom-nav>