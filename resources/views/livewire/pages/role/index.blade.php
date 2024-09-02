<x-frk.components.template-index>
    <x-slot:head>
        <x-frk.components.title label="{{$title}}" />
        <x-frk.components.button label="agregar" wire:click="create()" />
    </x-slot:head>
    <x-slot:body>
        <livewire:power-grid.role-table/>
    </x-slot:body>
    <x-slot:footer>
        @if($isCreate)
            @include('livewire.pages.role.create')
        @endif
        @if($isEdit)
            @include('livewire.pages.role.edit')
        @endif
        @if($isShow)
            @include('livewire.pages.role.show')
        @endif
        @if($isDelete)
            @include('livewire.pages.role.delete')
        @endif
    </x-slot:footer>
</x-frk.components.template-index>
