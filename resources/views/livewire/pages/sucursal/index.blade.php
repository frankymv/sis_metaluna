<x-frk.components.template-index>
    <x-slot:head>
        <x-frk.components.title label="{{$title}}" />
        <x-frk.components.button label="agregar" wire:click="create()" />
    </x-slot:head>
    <x-slot:body>
        <livewire:power-grid.sucursal-table/>
    </x-slot:body>
    <x-slot:footer>
        @if($isCreate)
            @include('livewire.pages.sucursal.create')
        @endif
        @if($isEdit)
            @include('livewire.pages.sucursal.edit')
        @endif
        @if($isShow)
            @include('livewire.pages.sucursal.show')
        @endif
        @if($isDelete)
            @include('livewire.pages.sucursal.delete')
        @endif
    </x-slot:footer>
</x-frk.components.template-index>
