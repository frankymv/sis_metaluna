<x-frk.components.template-crud maxWidth="3xl">
    <x-slot:title>
        <div class=" w-full md:w-2/4">
            <x-frk.components.subtitle  label="Nota credito" />
        </div>
        <div class="flex w-full md:w-1/4">
            <x-frk.components.input-money  label="no nota credito" error="codigo" :disabled="$disabled" wire:model.live="no_nota_credito" />
        </div>
        <div class="flex w-full md:w-1/4">
            <x-frk.components.date-picker wire:model="fecha_nota_credito" error="fecha_nota_credito" label="Fecha nota credito"/>
        </div>
    </x-slot>
    <x-slot:body>
        @include('livewire.pages.nota_credito.form')
    </x-slot>
    <x-slot:footer>
        <x-frk.components.button label="guardar" wire:click.prevent="store()" />
        <x-frk.components.button label="cancelar" wire:click.prevent="cancel()" />
    </x-slot>
</x-frk.modal>

