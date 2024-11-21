    <x-frk.components.template-crud>
        <x-slot:title>
            <x-frk.components.title label="Nuevo {{$title}}" />
        </x-slot>
        <x-slot:body>
            @include('livewire.pages.marca.form')
        </x-slot>
        <x-slot:footer>
            <x-frk.components.button label="guardar" wire:click.prevent="store()" />
            <x-frk.components.button label="cancelar" wire:click.prevent="cancel()" />
        </x-slot>
   </x-frk.components.template-crud>

