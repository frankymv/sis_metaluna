<x-frk.components.template-index>
    <x-slot:head>
        <x-frk.components.title label="{{$title}}" />
        <x-frk.components.button label="agregar" wire:click="create()" />
    </x-slot:head>
    <x-slot:body>
        <livewire:power-grid.proveedor-table/>
    </x-slot:body>
    <x-slot:footer>
        @if($isCreate)
            @include('livewire.pages.proveedor.create')
        @endif
        @if($isEdit)
            @include('livewire.pages.proveedor.edit')
        @endif
        @if($isShow)
            @include('livewire.pages.proveedor.show')
        @endif
        @if($isDelete)
            @include('livewire.pages.proveedor.delete')
        @endif

    </x-slot:footer>
</x-frk.components.template-index>
