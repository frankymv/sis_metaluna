<x-frk.components.template-crud>
    <x-slot:title>
        <x-frk.components.title label="Nuevo {{$title}}" />
    </x-slot>
    <x-slot:body>
        @include('livewire.pages.ajuste_inventario.form')
    </x-slot>
    <x-slot:footer>
        <x-frk.components.button color="blue" label="guardar" wire:click="store()" />
        <x-frk.components.button label="cancelar" wire:click="cancel()" />
    </x-slot>
</x-frk.modal>

