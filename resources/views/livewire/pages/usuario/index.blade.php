<x-frk.components.template-index>
    <x-slot:head>
        <x-frk.components.title label="{{$title}}" />
        <x-frk.components.button label="agregar" wire:click="create()" />
    </x-slot:head>
    <x-slot:body>
        <livewire:power-grid.user-table/>
    </x-slot:body>
    <x-slot:footer>
        @if($isCreate)
            @include('livewire.pages.usuario.create')
        @endif
        @if($isEdit)
            @include('livewire.pages.usuario.edit')
        @endif
        @if($isShow)
            @include('livewire.pages.usuario.show')
        @endif
        @if($isDelete)
            @include('livewire.pages.usuario.delete')
        @endif
    </x-slot:footer>
</x-frk.components.template-index>
