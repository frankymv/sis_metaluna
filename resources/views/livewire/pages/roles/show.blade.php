<div>
    <x-frk.components.template-crud>
        <x-slot:title>
            <x-frk.components.title label="Detalle {{$title}}" />
        </x-slot>
        <x-slot:body>
            @include('livewire.pages.marca.form')
        </x-slot>
        <x-slot:footer>
            <x-frk.components.button label="Exportar" wire:click.prevent="export_pdf()" />
            <x-frk.components.button label="cancelar" wire:click.prevent="cancel()" />
        </x-slot>
   </x-frk.components.template-crud>
</div>
